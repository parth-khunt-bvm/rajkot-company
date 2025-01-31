<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;

class EmployeeBirthday extends Model
{
    use HasFactory;
    protected $table = 'employee';

    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'employee.id',
            1 => 'employee.DOB',
            2 => DB::raw('CONCAT(first_name, " ", last_name)'),
            3 => 'technology.technology_name',
            4 => 'designation.designation_name',
        );

        $query = EmployeeBirthday::from('employee')
            ->join("technology", "technology.id", "=", "employee.department")
            ->join("designation", "designation.id", "=", "employee.designation")
            ->join("branch", "branch.id", "=", "employee.branch")
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->where("employee.status", "=", "W")
            ->where("employee.is_deleted", "=", "N");

        if ($fillterdata['bdayTime'] == 0) {
            $query->where(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), '=', date("m-d", strtotime("yesterday")));
        }
        if ($fillterdata['bdayTime'] == 1) {
            $query->where(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), '=', now()->format('m-d'));
        }
        if ($fillterdata['bdayTime'] == 2) {
            $query->where(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), '=', date("m-d", strtotime('tomorrow')));
        }
        if ($fillterdata['bdayTime'] == 3) {
            $query->whereBetween(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), array(date("m-d", strtotime('monday this week')), date("m-d", strtotime("sunday this week"))));
        }
        if ($fillterdata['bdayTime'] == 4) {
            $query->whereBetween(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), array(date("m-d", strtotime(today()->startOfMonth())), date("m-d", strtotime(today()->endOfMonth()))));
        }

        if ($fillterdata['bdayTime'] == 5) {
            $currentMonth = today()->startOfMonth();

            // Move to the next month
            $nextMonth = $currentMonth->addMonth();

            // Apply whereBetween with correct formatting
            $query->whereBetween(
                DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'),
                [$nextMonth->startOfMonth()->format('m-d'), $nextMonth->endOfMonth()->format('m-d')]
            );
        }

        if (!empty($fillterdata['startDate'])) {
            $startDate = date('m-d', strtotime($fillterdata['startDate']));
            $query->whereRaw('DATE_FORMAT(employee.DOB, "%m-%d") >= ?', [$startDate]);
        }

        if (!empty($fillterdata['endDate'])) {
            $endDate = date('m-d', strtotime($fillterdata['endDate']));
            $query->whereRaw('DATE_FORMAT(employee.DOB, "%m-%d") <= ?', [$endDate]);
        }

        // if($fillterdata['startDate'] != null && $fillterdata['startDate'] != ''){
        //     $query->whereDate(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), '>=', date('m-d', strtotime($fillterdata['startDate'])));
        // }

        // if($fillterdata['endDate'] != null && $fillterdata['endDate'] != ''){
        //     $query->whereDate(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), '<=',  date('m-d', strtotime($fillterdata['endDate'])));
        // }

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
            ->select('employee.id', DB::raw('CONCAT(first_name, " ", last_name) as full_name'), 'branch.branch_name', 'technology.technology_name', 'designation.designation_name', 'employee.DOB')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['DOB']);
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

    public function employeeBirthdayList()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'employee.id',
            1 => DB::raw('CONCAT(first_name, " ", last_name)'),
            2 => 'employee.DOB',
            3 => 'technology.technology_name',
            4 => 'designation.designation_name',
        );

        $query = EmployeeBirthday::from('employee')
            ->join("technology", "technology.id", "=", "employee.department")
            ->join("designation", "designation.id", "=", "employee.designation")
            ->join("branch", "branch.id", "=", "employee.branch")
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->where("employee.is_deleted", "=", "N")
            ->where("employee.status", "=", "W")
            ->whereBetween(DB::raw('DATE_FORMAT(employee.DOB, "%m-%d")'), array(date("m-d", strtotime(today()->startOfMonth())), date("m-d", strtotime(today()->endOfMonth()))));

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
            ->select('employee.id', DB::raw('CONCAT(first_name, " ", last_name) as full_name'), 'branch.branch_name', 'technology.technology_name', 'designation.designation_name', 'employee.DOB')
            ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = date_formate($row['DOB']);
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
}
