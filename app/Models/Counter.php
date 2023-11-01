<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Route;
use DB;

class Counter extends Model
{
    use HasFactory;

    protected $table = 'counter';

    protected $fillable = [
            'month',
            'year',
            'employee_id',
            'technology_id',
            'present_days',
            'half_leaves',
            'full_leaves',
            'paid_leaves_details',
            'total_days',
            'salary_counted',
            'paid_date',
            'salary_status',
            'note',
    ];
    public function getdatatable($fillterdata)
    {
        // dd($fillterdata);
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'counter.id',
            1 =>  DB::raw('MONTHNAME(CONCAT("2023-", counter.month, "-01"))'),
            2 => 'counter.year',
            3 =>  DB::raw('CONCAT(first_name, " ", last_name)'),
            4 => 'technology.technology_name',
            5 => 'counter.present_days',
            6 => 'counter.half_leaves',
            7 => 'counter.full_leaves',
            8 => 'counter.paid_leaves_details',
            9 => 'counter.total_days',
            10 => DB::raw('(CASE WHEN counter.salary_counted = "Y" THEN "Yes" ELSE "No" END)'),

        );

        $query = Counter::from('counter')
            ->join("employee", "employee.id", "=", "counter.employee_id")
            ->join("technology", "technology.id", "=", "counter.technology_id")
            ->where("counter.is_deleted", "=", "N");

        if($fillterdata['month'] != null && $fillterdata['month'] != ''){
            $query->where("counter.month", $fillterdata['month']);
        }

        if($fillterdata['year'] != null && $fillterdata['year'] != ''){
            $query->where("counter.year", $fillterdata['year']);
        }

        if($fillterdata['employee'] != null && $fillterdata['employee'] != ''){
            $query->where("employee.id", $fillterdata['employee']);
        }

        if($fillterdata['technology'] != null && $fillterdata['technology'] != ''){
            $query->where("technology.id", $fillterdata['technology']);
        }




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
            ->select('counter.id', DB::raw('CONCAT(first_name, " ", last_name) as fullname'), DB::raw('MONTHNAME(CONCAT("2023-", counter.month, "-01")) as month_name'), 'employee.first_name', 'technology.technology_name', 'counter.present_days', 'counter.half_leaves', 'counter.full_leaves', 'counter.paid_leaves_details', 'counter.total_days', 'counter.month', 'counter.year', 'counter.salary_counted')
            ->get();

        $data = array();
        $i = 0;
        $max_length = 30;
        foreach ($resultArr as $row) {

            $actionhtml = '';
            $actionhtml .= '<a href="' . route('admin.counter.view', $row['id']) . '" class="btn btn-icon"><i class="fa fa-eye text-primary"> </i></a>';
            $actionhtml .= '<a href="' . route('admin.counter.edit', $row['id']) . '" class="btn btn-icon"><i class="fa fa-edit text-warning"> </i></a>';
            if ($row['salary_counted'] == 'Y') {
                $salaryCounted = '<span class="label label-lg label-light-success label-inline">Yes</span>';
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#salaryNotCounted" class="btn btn-icon  salary-not-counted" data-id="' . $row["id"] . '" ><i class="fa fa-times text-primary" ></i></a>';
            } else {
                $salaryCounted = '<span class="label label-lg label-light-danger  label-inline">No</span>';
                $actionhtml .= '<a href="#" data-toggle="modal" data-target="#salaryCounted" class="btn btn-icon  salary-counted" data-id="' . $row["id"] . '" ><i class="fa fa-check text-primary" ></i></a>';
            }
            $actionhtml .= '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-records" data-id="' . $row["id"] . '" ><i class="fa fa-trash text-danger" ></i></a>';

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] =  $row['month_name'];
            $nestedData[] = $row['year'];
            $nestedData[] = $row['fullname'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] =  numberformat($row['present_days'], 0);
            $nestedData[] = $row['half_leaves'];
            $nestedData[] = $row['full_leaves'];
            $nestedData[] = $row['paid_leaves_details'];
            $nestedData[] = numberformat($row['total_days'], 0);
            $nestedData[] = $salaryCounted;
            $nestedData[] = $actionhtml;

            if (strlen($row['remarks']) > $max_length) {
                $nestedData[] = substr($row['remarks'], 0, $max_length) . '...';
            } else {
                $nestedData[] = $row['remarks']; // If it's not longer than max_length, keep it as is
            }
            $nestedData[] = $actionhtml;
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

    public function saveAdd($requestData)
    {
        $countCounter = Counter::from('counter')
            ->where('counter.month', $requestData['month'])
            ->where('counter.year', $requestData['year'])
            ->where('counter.employee_id', $requestData['employee_id'])
            ->where('counter.technology_id', $requestData['technology_id'])
            ->where('counter.is_deleted', 'N')
            ->count();

        if ($countCounter == 0) {
            $objCounter = new Counter();
            $objCounter->month = $requestData['month'];
            $objCounter->year = $requestData['year'];
            $objCounter->employee_id = $requestData['employee_id'];
            $objCounter->technology_id = $requestData['technology_id'];
            $objCounter->present_days = $requestData['present_day'];
            $objCounter->half_leaves = $requestData['half_leaves'] ?? '-';
            $objCounter->full_leaves = $requestData['full_leaves'] ?? '-';
            $objCounter->total_days = $requestData['total_days'] ?? '-';
            $objCounter->paid_leaves_details = $requestData['paid_leaves_details'];
            $objCounter->paid_date = date('Y-m-d', strtotime($requestData['date']));
            $objCounter->salary_status = $requestData['salary_status'];
            $objCounter->salary_counted = $requestData['salary_counted'];
            $objCounter->note = $requestData['note'];
            $objCounter->is_deleted = 'N';
            $objCounter->created_at = date('Y-m-d H:i:s');
            $objCounter->updated_at = date('Y-m-d H:i:s');
            if ($objCounter->save()) {
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $res = $objAudittrails->add_audit('I', $requestData, 'Counter');
                return 'added';
            }
            return 'wrong';
        }
        return 'counter_exists';
    }

    public function saveEdit($requestData)
    {
        $countCounter = Counter::from('counter')
            ->where('counter.month', $requestData['month'])
            ->where('counter.year', $requestData['year'])
            ->where('counter.employee_id', $requestData['employee_id'])
            ->where('counter.technology_id', $requestData['technology_id'])
            ->where('counter.id', "!=", $requestData['counter_id'])
            ->count();
        if ($countCounter == 0) {
            $objCounter = Counter::find($requestData['counter_id']);
            $objCounter->month = $requestData['month'];
            $objCounter->year = $requestData['year'];
            $objCounter->employee_id = $requestData['employee_id'];
            $objCounter->technology_id = $requestData['technology_id'];
            $objCounter->present_days = $requestData['present_day'];
            $objCounter->half_leaves = $requestData['half_leaves'] ?? '-';
            $objCounter->full_leaves = $requestData['full_leaves'] ?? '-';
            $objCounter->total_days = $requestData['total_days'] ?? '-';
            $objCounter->paid_leaves_details = $requestData['paid_leaves_details'];
            $objCounter->paid_date = date('Y-m-d', strtotime($requestData['date']));
            $objCounter->salary_status = $requestData['salary_status'];
            $objCounter->salary_counted = $requestData['salary_counted'];
            $objCounter->note = $requestData['note'];
            $objCounter->updated_at = date('Y-m-d H:i:s');
            if ($objCounter->save()) {
                unset($requestData['_token']);
                $objAudittrails = new Audittrails();
                $objAudittrails->add_audit('U', $requestData, 'Counter');
                return 'added';
            }
            return 'wrong';
        }
        return 'counter_exists';
    }

    public function get_counter_detail($counterId)
    {
        return Counter::from('counter')
            ->join("employee", "employee.id", "=", "counter.employee_id")
            ->join("technology", "technology.id", "=", "counter.technology_id")
            ->select('counter.id', 'counter.month', 'counter.technology_id', 'employee.first_name', 'technology.technology_name', 'counter.year', 'counter.present_days', 'counter.half_leaves', 'counter.full_leaves', 'counter.paid_leaves_details', 'counter.total_days', 'counter.salary_counted', 'counter.paid_date', 'counter.salary_status', 'counter.note', "counter.employee_id")
            ->where('counter.id', $counterId)
            ->first();
    }

    public function common_activity($requestData)
    {
        $objCounter = Counter::find($requestData['id']);
        if ($requestData['activity'] == 'delete-records') {
            $objCounter->is_deleted = "Y";
            $event = 'Delete Records';
        }

        if ($requestData['activity'] == 'salary-counted') {
            $objCounter->salary_counted = "Y";
            $event = 'Salary Counted';
        }

        if ($requestData['activity'] == 'salary-not-counted') {
            $objCounter->salary_counted = "N";
            $event = 'Salary Not Counted';
        }

        $objCounter->updated_at = date("Y-m-d H:i:s");

        if ($objCounter->save()) {
            $currentRoute = Route::current()->getName();
            unset($requestData['_token']);
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, $requestData, 'Counter');

            return true;
        } else {
            return false;
        }
    }

}
