<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class EmpAttendance extends Model
{
    use HasFactory;
    protected $table = "attendance";

    public function get_attendance_details_by_employee($employeeId, $month, $year)
    {
        $month = $year . '-' . $month;
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $period = CarbonPeriod::create($start, $end);

        $dates = [];
        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            if ($formattedDate <= date('Y-m-d')) {
                $isHoliday = PublicHoliday::from('public_holiday')
                    ->where('date', $formattedDate)
                    ->where('is_deleted', 'N')
                    ->select('holiday_name')
                    ->first();

                $dates[] = [
                    'date' => $formattedDate,
                    'attendance_type' => null, // Default value for attendance type
                    'class' => null, // Default value for class
                    'description' => null, // Default value for description
                    'is_holiday' => !empty($isHoliday) ? $isHoliday->holiday_name : "null", // Holiday data
                    'emp_overtime' => EmployeeOvertime::from('emp_overtime')
                        ->join('employee', 'employee.id', '=', 'emp_overtime.employee_id')
                        ->where('date', $formattedDate)
                        ->where('emp_overtime.employee_id', $employeeId)
                        // ->whereIn('employee.branch', $_COOKIE['branch'] == 'all' ? user_branch(true) : [$_COOKIE['branch']])
                        ->sum('hours'), // Employee overtime data
                ];
            }
        }

        $attendanceData = Attendance::from('attendance')
            ->select('attendance.date', 'attendance.attendance_type', 'attendance.reason')
            ->where('attendance.employee_id', $employeeId)
            ->whereDate('date', '>=', $start)
            ->whereDate('date', '<=', $end)
            ->get();

        foreach ($attendanceData as $value) {
            $dateIndex = array_search($value->date, array_column($dates, 'date')); // No need to format here
            if ($dateIndex !== false) {
                switch ($value->attendance_type) {
                    case 0:
                        $attendance_type = 'Present';
                        $className = 'fc-event-success';
                        $description = $value->reason;
                        break;
                    case 1:
                        $attendance_type = 'Absent';
                        $className = 'fc-event-danger';
                        $description = $value->reason;
                        break;
                    case 2:
                        $attendance_type = 'Half Leave';
                        $className = 'fc-event-info';
                        $description = $value->reason;
                        break;
                    default:
                        $attendance_type = 'Short Leave';
                        $className = 'fc-event-warning';
                        $description = $value->reason;
                        break;
                }
                $dates[$dateIndex]['attendance_type'] = $attendance_type;
                $dates[$dateIndex]['class'] = $className;
                $dates[$dateIndex]['description'] = $description;
            }
        }

        return $dates;
    }
}
