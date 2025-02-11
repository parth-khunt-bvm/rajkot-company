<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmployeeBondLastDate extends Model
{
    use HasFactory;

    protected $table = 'employee';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'employee.id',
            1 => 'employee.bond_last_date',
            2 => DB::raw('CONCAT(first_name, " ", last_name)'),
            3 => 'technology.technology_name',
            4 => 'designation.designation_name',
        );

        $query = Employee::from('employee')
             ->join("technology", "technology.id", "=", "employee.department")
             ->join("designation", "designation.id", "=", "employee.designation")
             ->join("branch", "branch.id", "=", "employee.branch")
             ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
             ->where("employee.is_deleted", "=", "N")
             ->where("employee.status", "=", "W");

             if($fillterdata['bondLastDateTime'] == 0){
                $query->where("employee.bond_last_date", '=', date("Y-m-d", strtotime("yesterday")));
             }
             if($fillterdata['bondLastDateTime'] == 1){
                $query->where("employee.bond_last_date", '=', now()->format('Y-m-d'));
             }
             if($fillterdata['bondLastDateTime'] == 2){
                $query->where("employee.bond_last_date", '=', date("Y-m-d", strtotime('tomorrow')));
             }
             if($fillterdata['bondLastDateTime'] == 3){
                $query->whereBetween("employee.bond_last_date", array(date("Y-m-d",strtotime('monday this week')), date("Y-m-d",strtotime("sunday this week"))));
             }
             if($fillterdata['bondLastDateTime'] == 4){
                $query->whereBetween("employee.bond_last_date", array(date("Y-m-d", strtotime( today()->startOfMonth())), date("Y-m-d", strtotime( today()->endOfMonth()))));
             }

             if ($fillterdata['bondLastDateTime'] == 5) {
                $startOfMonth = today()->addMonth()->startOfMonth();
                $endOfMonth = today()->addMonth()->endOfMonth();

                $startOfMonthFormatted = $startOfMonth->format('Y-m-d');
                $endOfMonthFormatted = $endOfMonth->format('Y-m-d');

                $query->whereBetween('employee.bond_last_date', array($startOfMonthFormatted, $endOfMonthFormatted));
            }

            if($fillterdata['startDate'] != null && $fillterdata['startDate'] != ''){
                $query->whereDate('bond_last_date', '>=', date('Y-m-d', strtotime($fillterdata['startDate'])));
            }
            if($fillterdata['endDate'] != null && $fillterdata['endDate'] != ''){
                $query->whereDate('bond_last_date', '<=',  date('Y-m-d', strtotime($fillterdata['endDate'])));
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
            ->select( 'employee.id', DB::raw('CONCAT(first_name, " ", last_name) as full_name'), 'technology.technology_name', 'designation.designation_name', 'employee.bond_last_date')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            // $nestedData[] = date_formate($row['bond_last_date'])
            $nestedData[] = $row['bond_last_date'] != '' && $row['bond_last_date'] != NULL ? date_formate($row['bond_last_date']) : '-';
            $nestedData[] = $row['full_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['designation_name'];
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

    public function employeeBondLastDateList()
    {

        $requestData = $_REQUEST;
        $columns = array(
            0 => 'employee.id',
            1 => DB::raw('CONCAT("Name :", first_name, " ", last_name, "<br>Gmail : ", employee.gmail,  "<br>Contact : ", employee.personal_number)'),
            2 => 'employee.bond_last_date',
            3 => 'technology.technology_name',
            4 => 'designation.designation_name',
        );

        $query = Employee::from('employee')
             ->join("technology", "technology.id", "=", "employee.department")
             ->join("designation", "designation.id", "=", "employee.designation")
             ->join("branch", "branch.id", "=", "employee.branch")
             ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
             ->where("employee.status", "=", "W")
             ->where("employee.is_deleted", "=", "N")
             ->where("employee.bond_last_date", "<", date("Y-m-d"));
            //  ->whereBetween("employee.bond_last_date", array(date("Y-m-d", strtotime( today()->startOfMonth())), date("Y-m-d", strtotime( today()->endOfMonth()))));

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
            ->select( 'employee.id', DB::raw('CONCAT(first_name, " ", last_name) as full_name'),  'employee.employee_image', 'technology.technology_name', 'designation.designation_name', 'employee.bond_last_date', 'employee.gmail','employee.personal_number')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $i++;
            $nestedData = array();
            $nestedData[] = $i;

            if(file_exists( public_path() . '/upload/userprofile/' . $row['employee_image']) && $row['employee_image'] != ''){
                $image = url("upload/userprofile/" . $row['employee_image']);
            } else {
                $image = url("upload/userprofile/default.jpg");
            }

            $nestedData[] = '<div class="d-flex align-items-center">'.
            '<div class="symbol symbol-50 symbol-sm flex-shrink-0">'.
            '<div class="symbol-label">'.
            '<img height="48" class="align-self-end pre-img" src="' . $image . '" alt="photo"/>'.
            '</div>'.
            '</div>'.
            '<div class="ml-4">'.
            '<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">' . $row['full_name'] . '</div>'.
            '<a href="#" class="text-muted font-weight-bold text-hover-primary">' . $row['gmail'] . '</a>'.
            '</div>'.
            '</div>';
            $nestedData[] = date_formate($row['bond_last_date']);
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['designation_name'];
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

    public function getEmployee(){
        return Employee::from('employee')
             ->join("technology", "technology.id", "=", "employee.department")
             ->join("designation", "designation.id", "=", "employee.designation")
             ->join("branch", "branch.id", "=", "employee.branch")
             ->select( 'employee.id', 'technology.technology_name', 'designation.designation_name', 'employee.bond_last_date','employee.first_name', 'employee.last_name','employee.DOJ','employee.gmail', 'employee.personal_number','employee.bond_last_date')
             ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']] )
             ->where("employee.is_deleted", "=", "N")
             ->where("employee.status", "=", "W")
             ->where("employee.bond_last_date", '=', now()->format('Y-m-d'))
             ->get();
    }
}
