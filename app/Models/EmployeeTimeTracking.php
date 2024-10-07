<?php

namespace App\Models;

use Auth;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeTimeTracking extends Model
{
    use HasFactory;
    protected $prefix = 'tracker_';

    public function getTable()
    {
        $employeeCode = Auth::guard('employee')->user()->employee_code;
        return $this->prefix . $employeeCode;
    }

    public function getdatatable()
    {
        // $requestData = $_REQUEST;
        $requestData = request()->all();
        $employeeCode = Auth::guard('employee')->user()->employee_code;
        $tableName = 'tracker_' . $employeeCode;

        $columns = [
            0 => $tableName . '.id',
            1 => $tableName . '.date',
            2 => $tableName . '.in_time',
            3 => $tableName . '.out_time',
        ];
        $query = EmployeeTimeTracking::from($tableName);

        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchVal = $requestData['search']['value'];
            $query->where(function ($query) use ($columns, $searchVal, $requestData) {
                $flag = 0;
                foreach ($columns as $key => $value) {
                    $searchVal = $requestData['search']['value'];
                    if ($requestData['columns'][$key]['searchable'] == 'true') {
                        if ($flag == 0) {
                            $query->where($value, 'like', '%' . $searchVal . '%');
                            $flag = $flag + 1;
                        } else {
                            $query->orWhere($value, 'like', '%' . $searchVal . '%');
                        }
                    }
                }
            });
        }

        $temp = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $totalData = count($temp->get());
        $totalFiltered = count($temp->get());

        $resultArr = $query->skip($requestData['start'])
            ->take($requestData['length'])
            ->select($tableName . '.id', $tableName . '.date', $tableName . '.in_time', $tableName . '.out_time',)
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['date']);

            $inTime = new DateTime($row['in_time']);
            $outTime = new DateTime($row['out_time']);

            $inTime12Hour = $inTime->format('h:i:s A'); // Example: 04:30:00 PM
            $outTime12Hour = $outTime->format('h:i:s A');

            $nestedData[] = $inTime12Hour;
            $nestedData[] = $outTime12Hour;

            // Calculate the difference
            $inTime = DateTime::createFromFormat('H:i:s', $row['in_time']);
            $outTime = DateTime::createFromFormat('H:i:s', $row['out_time']);

            $timeDifference = $outTime->diff($inTime);

            // Output the difference
            // echo $timeDifference->format('%H:%I:%S');

            $nestedData[] = $timeDifference->format('%H:%I:%S');
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );
        return $json_data;
    }

    public function getAdminDatatable($request)
    {
        $requestData = request()->all();
        $dateObject = Carbon::createFromFormat('d-M-Y', $request['date']);
        $outputDate = $dateObject->format('Y-m-d');
        $employeeData = Employee::from('employee')
            ->select('employee_code', DB::raw('CONCAT(first_name, " ", last_name) as fullName'))
            ->where('is_deleted', '=', 'N')
            ->get();
        foreach(json_decode($employeeData) as $employee => $empCode) {
            $empCodes[] = [strtolower($empCode->employee_code), $empCode->fullName];
        }
        $tables = [];
        foreach($empCodes as $empCode){
            $tables[] = 'tracker_' . $empCode[0];
        }
        foreach($tables as $index => $table){

            $query[] = EmployeeTimeTracking::from($table)
                ->where('date', '=', $outputDate)
                ->get();
            $columns = [
                0 => $table . '.id',
                1 => $table . '.date',
                2 => $table . '.in_time',
                3 => $table . '.out_time',
            ];
            if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $searchVal = $requestData['search']['value'];
                $query->where(function ($query) use ($columns, $searchVal, $requestData) {
                    $flag = 0;
                    foreach ($columns as $key => $value) {
                        $searchVal = $requestData['search']['value'];
                        if ($requestData['columns'][$key]['searchable'] == 'true') {
                            if ($flag == 0) {
                                $query->where($value, 'like', '%' . $searchVal . '%');
                                $flag = $flag + 1;
                            } else {
                                $query->orWhere($value, 'like', '%' . $searchVal . '%');
                            }
                        }
                    }
                });
            }
    
            $temp = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
    
            $totalData = count($temp->get());
            $totalFiltered = count($temp->get());
    
            $resultArr = $query->skip($requestData['start'])
                ->take($requestData['length'])
                ->select($table . '.id', $table . '.date', $table . '.in_time', $table . '.out_time',)
                ->get();
    
            $data = array();
            $i = 0;

        }
        return $resultArr;
    }

    public function storeStartTime($requestData)
    {
        $dt = new DateTime();
        $dt->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $indianDateTime = $dt->format('Y-m-d H:i:s');

        $objEmployeeTimeTracking = new EmployeeTimeTracking();
        $objEmployeeTimeTracking->date = $dt->format('Y-m-d');
        $objEmployeeTimeTracking->in_time = $indianDateTime;
        $objEmployeeTimeTracking->out_time = "";
        $objEmployeeTimeTracking->created_at = $indianDateTime;
        $objEmployeeTimeTracking->updated_at = $indianDateTime;

        if ($objEmployeeTimeTracking->save()) {
            $inputData = $requestData->input();
            unset($inputData['_token']);
            $objAudittrails = new Audittrails();
            $objAudittrails->add_audit("I", $inputData, 'Time Traking   ');
            return 'added';
        } else {
            return 'wrong';
        }
    }

    public function storeStopTime($requestData)
    {
        $dt = new DateTime();
        $dt->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $indianDateTime = $dt->format('Y-m-d H:i:s');

        // $EmployeeTimeTracking = EmployeeTimeTracking::where('date', $dt->format('Y-m-d'))
        // ->whereNotNull('in_time')
        // ->whereNull('out_time')
        // ->latest()
        // ->first();
        $EmployeeTimeTracking = EmployeeTimeTracking::latest()->first();

        if ($EmployeeTimeTracking) {
            // $EmployeeTimeTracking->date = $dt->format('Y-m-d');
            $EmployeeTimeTracking->out_time = $indianDateTime;
            $EmployeeTimeTracking->updated_at = $indianDateTime;

            if ($EmployeeTimeTracking->save()) {
                $inputData = $requestData->input();
                unset($inputData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit("U", $inputData, 'Time Tracking');
                return 'updated';
            } else {
                return 'wrong';
            }
        } else {
            return 'No ongoing time tracking found.';
        }
    }


}
