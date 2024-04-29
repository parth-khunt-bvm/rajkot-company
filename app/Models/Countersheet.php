<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Employee;
use PDF;

class Countersheet extends Model
{
    use HasFactory;
    protected $table = "attendance";
    public function getdatatable($fillterdata)
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'employee.id',
            1 => \DB::raw('CONCAT(employee.first_name, " ", employee.last_name)'),
            2 => 'technology.technology_name',
            3 => \DB::raw('COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.halfDayCount, 0) + COALESCE(a.sortLeaveCount, 0)'),
            4 => 'a.presentCount',
            // 5 => 'a.absentCount',
            // 5 => \DB::raw('COALESCE(a.absentCount, 0) + COALESCE(a.halfDayCount, 0)'),
            5 => DB::raw('ROUND(((COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1)'),
            6 => 'a.halfDayCount',
            7 => 'a.sortLeaveCount',
            8 =>  DB::raw('IFNULL(o.overTime, 0)'),
            9 =>  DB::raw('ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1)'),
            10 => 'a.totalsortLeaveHours'

        );
        $query = Employee::query()
            ->join('technology', 'technology.id', '=', 'employee.department')
            ->leftJoin(\DB::raw('(SELECT employee_id, SUM(hours) AS overTime FROM emp_overtime WHERE MONTH(date) ='  . $fillterdata['month'] . ' AND YEAR(date) = '  . $fillterdata['year'] . ' GROUP BY employee_id) o'), 'o.employee_id', '=', 'employee.id')
            ->leftJoin(\DB::raw('(SELECT employee_id,
            COUNT(CASE WHEN attendance_type = "0" THEN 1  END) AS presentCount,
            COUNT(CASE WHEN attendance_type = "1" THEN 1  END) AS absentCount,
            COUNT(CASE WHEN attendance_type = "2" THEN 1  END) AS halfDayCount,
            COUNT(CASE WHEN attendance_type = "3" THEN 1  END) AS sortLeaveCount,
            CONCAT(SUM(CASE WHEN attendance_type = "3" THEN minutes END), " min")  AS totalsortLeaveHours
            FROM attendance WHERE MONTH(date) ='  . $fillterdata['month'] . ' AND YEAR(date) = ' . $fillterdata['year'] . '
            GROUP BY employee_id) a'), 'a.employee_id', '=', 'employee.id')
            ->where('a.employee_id', '!=', ' ')
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->where('employee.is_deleted', 'N');


        if ($fillterdata['technology'] != null && $fillterdata['technology'] != '') {
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
            ->select(
                'employee.id',
                'technology.technology_name',
                DB::raw('IFNULL(o.overTime, 0) as overTime'),
                DB::raw('CONCAT(employee.first_name, " ", employee.last_name) AS full_name'),
                DB::raw('COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.halfDayCount, 0) + COALESCE(a.sortLeaveCount, 0) AS totalDays'),
                'a.presentCount',
                // 'a.absentCount',
                // \DB::raw(' COALESCE(a.absentCount, 0) + COALESCE(a.halfDayCount, 0) as absentDay'),
                // DB::raw('ROUND(((COALESCE(1, 0) * 0) + (COALESCE(1) * 4)) / 8, 1) as absentDay'),
                DB::raw('ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) as absentDay'),

                'a.halfDayCount',
                'a.sortLeaveCount',
                'a.totalsortLeaveHours',

                // Calculate total working days
                DB::raw('ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1) AS totalWorkingDays')
            )
            ->get();
        $data = array();
        $i = 0;
        foreach ($resultArr as $row) {

            $actionhtml  = '';
            $actionhtml  =  '<button data-toggle="modal" data-user-id="' . $row['id'] . '" data-month="' . $fillterdata['month'] . '"  data-year="' . $fillterdata['year'] . '"data-target="#counter-sheet" class="counter-sheet btn btn-icon user-menu"><i class="fa fa-eye text-primary"> </i></button>';
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['full_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['totalDays'];
            $nestedData[] = $row['presentCount'];
            $nestedData[] = $row['absentDay'];
            if ($row['totalsortLeaveHours'] != null) {
                $nestedData[] = $row['sortLeaveCount'] . " (" . $row['totalsortLeaveHours'] . ")";
            } else {
                $nestedData[] = $row['sortLeaveCount'];
            }

            $nestedData[] = numberformat($row['overTime']);
            $nestedData[] = $row['totalWorkingDays'];

            $totalDays = $row['totalDays'];
            if ($row['totalWorkingDays'] >= 15) {
                if ($row['absentDay'] >= 1) {
                    $absentDay = $row['absentDay'] - 1;
                    $totalDays =  $row['totalDays'] - $absentDay;

                    if ($row['totalsortLeaveHours'] != null) {
                        // Convert sort leave minutes to hours
                        $sortLeaveHours = (intval($row['totalsortLeaveHours']) / 60) / 8;
                        // dd($sortLeaveHours);
                        // Subtract sort leave hours from total days
                        $totalDays -= $sortLeaveHours;
                    }
                }
            } else {

                if ($row['absentDay'] >= 1) {
                    $absentDay = $row['absentDay'];
                    $totalDays =  $row['totalDays'] - $absentDay;

                    if ($row['totalsortLeaveHours'] != null) {
                        // Convert sort leave minutes to hours
                        $sortLeaveHours = (intval($row['totalsortLeaveHours']) / 60) / 8;
                        // dd($sortLeaveHours);
                        // Subtract sort leave hours from total days
                        $totalDays -= $sortLeaveHours;
                    }
                }
            }

            if ($row['overTime'] > 0) {
                $overtimeHours = $row['overTime'] / 8; // Convert overtime minutes to hours
                $totalDays += $overtimeHours;
            }

            $nestedData[] = $totalDays;
            // $nestedData[] = $a;
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
    public function counterSheetPdf($technology, $month, $year)
    {
        $query = Employee::query()
            ->join('technology', 'technology.id', '=', 'employee.department')

            ->leftJoin(\DB::raw('(SELECT employee_id, SUM(hours) AS overTime FROM emp_overtime WHERE MONTH(date) =' . $month . ' AND YEAR(date) = ' . $year . ' GROUP BY employee_id) o'), 'o.employee_id', '=', 'employee.id')
            ->leftJoin(\DB::raw('(SELECT employee_id,
            COUNT(CASE WHEN attendance_type = "0" THEN 1  END) AS presentCount,
            COUNT(CASE WHEN attendance_type = "1" THEN 1  END) AS absentCount,
            COUNT(CASE WHEN attendance_type = "2" THEN 1  END) AS halfDayCount,
            COUNT(CASE WHEN attendance_type = "3" THEN 1  END) AS sortLeaveCount,
            CONCAT(SUM(CASE WHEN attendance_type = "3" THEN minutes END), " min")  AS totalsortLeaveHours
            FROM attendance WHERE MONTH(date) ='  . $month . ' AND YEAR(date) = ' . $year . '
            GROUP BY employee_id) a'), 'a.employee_id', '=', 'employee.id')
            ->where('a.employee_id', '!=', ' ')
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->where('employee.is_deleted', 'N');

        if ($technology != null && $technology != '') {
            $query->where("technology.id", $technology);
        }

        return $query->select(
            'employee.id',
            'technology.technology_name',
            DB::raw('ROUND(IFNULL(o.overTime, 0), 1) as overTime'),
            DB::raw('CONCAT(employee.first_name, " ", employee.last_name) AS full_name'),
            DB::raw('COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.halfDayCount, 0) + COALESCE(a.sortLeaveCount, 0) AS totalDays'),
            'a.presentCount',
            'a.absentCount',
            'a.halfDayCount',
            'a.sortLeaveCount',
            'a.totalsortLeaveHours',

            // Calculate total working days
            DB::raw('ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1) AS totalWorkingDays')
        )->orderBy('full_name', 'ASC')->orderBy('technology_name', 'ASC')->get();
    }

    public function counterSheetExcel($technology, $month, $year)
    {
        $query = Employee::query()
            ->join('technology', 'technology.id', '=', 'employee.department')

            ->leftJoin(\DB::raw('(SELECT employee_id, SUM(hours) AS overTime FROM emp_overtime WHERE MONTH(date) =' . $month . ' AND YEAR(date) = ' . $year . ' GROUP BY employee_id) o'), 'o.employee_id', '=', 'employee.id')
            ->leftJoin(\DB::raw('(SELECT employee_id,
            COUNT(CASE WHEN attendance_type = "0" THEN 1  END) AS presentCount,
            COUNT(CASE WHEN attendance_type = "1" THEN 1  END) AS absentCount,
            COUNT(CASE WHEN attendance_type = "2" THEN 1  END) AS halfDayCount,
            COUNT(CASE WHEN attendance_type = "3" THEN 1  END) AS sortLeaveCount,
            CONCAT(SUM(CASE WHEN attendance_type = "3" THEN minutes END), " min")  AS totalsortLeaveHours
            FROM attendance WHERE MONTH(date) ='  . $month . ' AND YEAR(date) = ' . $year . '
            GROUP BY employee_id) a'), 'a.employee_id', '=', 'employee.id')
            ->where('a.employee_id', '!=', ' ')
            ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
            ->where('employee.is_deleted', 'N');

        if ($technology != null && $technology != '') {
            $query->where("technology.id", $technology);
        }

        $resultArr = $query->select(
            DB::raw('CONCAT(employee.first_name, " ", employee.last_name) AS full_name'),
            'technology.technology_name',
            DB::raw('COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) +  COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0) AS totalDays'),
            'a.presentCount',
            DB::raw('ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) as absentDay'),
            DB::raw('CONCAT(
                COALESCE(a.sortLeaveCount, 0),
               "(", COALESCE(a.totalsortLeaveHours, 0),")"
           ) AS sortLeaveInfo'),
            DB::raw('IFNULL(o.overTime, 0) as overTime'),
            // Calculate total working days
            DB::raw('ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1) AS totalWorkingDays'),
            // Apply additional calculations to get the final total days
            DB::raw('CASE
                    WHEN overTime > 0 THEN
                        CASE
                    WHEN totalsortLeaveHours IS NOT NULL THEN
                        CASE
                            WHEN ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1) >= 15 THEN
                                CASE
                    WHEN ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1) >= 15 THEN
                        CASE
                            WHEN (ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1)) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - (ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) - 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                    ELSE
                        CASE
                            WHEN ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                END - (totalsortLeaveHours / (60 * 8))
                            ELSE
                                CASE
                    WHEN ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1) >= 15 THEN
                        CASE
                            WHEN (ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1)) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - (ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) - 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                    ELSE
                        CASE
                            WHEN ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                END - (totalsortLeaveHours / (60 * 8))
                        END
                    ELSE
                        CASE
                    WHEN ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1) >= 15 THEN
                        CASE
                            WHEN (ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1)) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - (ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) - 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                    ELSE
                        CASE
                            WHEN ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                END
                END + (overTime / 8)
                    ELSE
                        CASE
                    WHEN totalsortLeaveHours IS NOT NULL THEN
                        CASE
                            WHEN ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1) >= 15 THEN
                                CASE
                    WHEN ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1) >= 15 THEN
                        CASE
                            WHEN (ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1)) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - (ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) - 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                    ELSE
                        CASE
                            WHEN ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                END - (totalsortLeaveHours / (60 * 8))
                            ELSE
                                CASE
                    WHEN ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1) >= 15 THEN
                        CASE
                            WHEN (ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1)) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - (ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) - 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                    ELSE
                        CASE
                            WHEN ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                END - (totalsortLeaveHours / (60 * 8))
                        END
                    ELSE
                        CASE
                    WHEN ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1) >= 15 THEN
                        CASE
                            WHEN (ROUND(((COALESCE(a.presentCount, 0) * 8) + (COALESCE(a.absentCount, 0) * 0) + (COALESCE(a.halfDayCount, 0) * 4) + (COALESCE(a.sortLeaveCount, 0) * 8)) / 8, 1)) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - (ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) - 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                    ELSE
                        CASE
                            WHEN ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1) >= 1 THEN
                                (COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)) - ROUND(((COALESCE(a.absentCount, 0) * 8) + (COALESCE(a.halfDayCount, 0) * 4)) / 8, 1)
                            ELSE
                                COALESCE(a.presentCount, 0) + COALESCE(a.absentCount, 0) + COALESCE(a.sortLeaveCount, 0) + COALESCE(a.halfDayCount, 0)
                        END
                END
                END
                END AS totalDaysWithOvertime')
        )
            ->get();
        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['full_name'];
            $nestedData[] = $row['technology_name'];
            $nestedData[] = $row['totalDays'];
            $nestedData[] = $row['presentCount'];
            // $nestedData[] = $row['absentDay'];
            if ($row['totalsortLeaveHours'] != null) {
                $nestedData[] = $row['sortLeaveCount'] . " (" . $row['totalsortLeaveHours'] . ")";
            } else {
                $nestedData[] = $row['sortLeaveCount'];
            }

            $nestedData[] = numberformat($row['overTime']);
            $nestedData[] = $row['totalWorkingDays'];

            $totalDays = $row['totalDays'];
            if ($row['totalWorkingDays'] >= 15) {
                if ($row['absentDay'] >= 1) {
                    $absentDay = $row['absentDay'] - 1;
                    $totalDays =  $row['totalDays'] - $absentDay;

                    if ($row['totalsortLeaveHours'] != null) {
                        // Convert sort leave minutes to hours
                        $sortLeaveHours = (intval($row['totalsortLeaveHours']) / 60) / 8;
                        // Subtract sort leave hours from total days
                        $totalDays -= $sortLeaveHours;
                    }
                }
            } else {

                if ($row['absentDay'] >= 1) {
                    $absentDay = $row['absentDay'];
                    $totalDays =  $row['totalDays'] - $absentDay;

                    if ($row['totalsortLeaveHours'] != null) {
                        // Convert sort leave minutes to hours
                        $sortLeaveHours = (intval($row['totalsortLeaveHours']) / 60) / 8;
                        // Subtract sort leave hours from total days
                        $totalDays -= $sortLeaveHours;
                    }
                }
            }

            if ($row['overTime'] > 0) {
                $overtimeHours = $row['overTime'] / 8; // Convert overtime minutes to hours
                $totalDays += $overtimeHours;
            }

            $nestedData[] = $totalDays;
            $data[] = $nestedData;
        }
        return $resultArr;
    }
}
