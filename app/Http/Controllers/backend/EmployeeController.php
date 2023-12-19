<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\EmployeeImport;
use App\Models\Attendance;
use App\Models\CompanyInfo;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Technology;
use Illuminate\Http\Request;
use Config;
use DB;
use PDF;

class EmployeeController extends Controller
{

    function __construct()
    {
        $this->middleware('admin');
    }

    public function list(Request $request)
    {

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $objDesignation = new Designation();
        $data['designation'] = $objDesignation->get_admin_designation_details();

        $objCompanyinfo = new CompanyInfo();
        $data['systemDetails'] = $objCompanyinfo->get_system_details(1);

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Employee list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Employee list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Employee list';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/datatables.bundle.css'
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/custom/datatables/datatables.bundle.js',
            'pages/crud/datatables/data-sources/html.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'employee.js',
        );
        $data['funinit'] = array(
            'Employee.init()'
        );
        $data['header'] = array(
            'title' => 'Employee list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Employee list' => 'Employee list',
            )
        );
        return view('backend.pages.employee.list', $data);
    }
    public function birthDayList(Request $request)
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(95, explode(',', $permission_array[0]['permission']))){
            $objTechnology = new Technology();
            $data['technology'] = $objTechnology->get_admin_technology_details();

            $objDesignation = new Designation();
            $data['designation'] = $objDesignation->get_admin_designation_details();

            $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Employee Birthday list';
            $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Employee Birthday list';
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Employee Birthday list';
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
                'plugins/custom/datatables/datatables.bundle.css'
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'plugins/custom/datatables/datatables.bundle.js',
                'pages/crud/datatables/data-sources/html.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'employee.js',
            );
            $data['funinit'] = array(
                'Employee.init()',
                'Employee.employee_birthday()',
            );
            $data['header'] = array(
                'title' => 'Employee Birthday list',
                'breadcrumb' => array(
                    'Dashboard' => route('my-dashboard'),
                    'Employee Birthday list' => 'Employee Birthday list',
                )
            );
            return view('backend.pages.employee.birthday_list', $data);
        }else{
            return redirect()->route('my-dashboard');
        }
    }

    public function bondLastDateList(Request $request)
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(96, explode(',', $permission_array[0]['permission']))){

            $objTechnology = new Technology();
            $data['technology'] = $objTechnology->get_admin_technology_details();

            $objDesignation = new Designation();
            $data['designation'] = $objDesignation->get_admin_designation_details();

            $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Employee Bond Last Date list';
            $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Employee Bond Last Date  list';
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Employee Bond Last Date  list';
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
                'plugins/custom/datatables/datatables.bundle.css'
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'plugins/custom/datatables/datatables.bundle.js',
                'pages/crud/datatables/data-sources/html.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'employee.js',
            );
            $data['funinit'] = array(
                'Employee.init()',
                'Employee.employee_bond_last_date()',
            );
            $data['header'] = array(
                'title' => 'Employee Bond Last Date list',
                'breadcrumb' => array(
                    'Dashboard' => route('my-dashboard'),
                    'Employee Bond Last Date list' => 'Employee Bond Last Date list',
                )
            );
            return view('backend.pages.employee.bond_last_date_list', $data);
        }else{
            return redirect()->route('my-dashboard');
        }

    }
    public function add()
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(74, explode(',', $permission_array[0]['permission']))){
            $objTechnology = new Technology();
            $data['technology'] = $objTechnology->get_admin_technology_details();

            $objDesignation = new Designation();
            $data['designation'] = $objDesignation->get_admin_designation_details();

            $objManager = new Manager();
            $data['manager'] = $objManager->get_admin_manager_details();

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Employee";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Employee";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Employee";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
                'pages/crud/file-upload/image-input.js'
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'employee.js',
            );
            $data['funinit'] = array(
                'Employee.add()'
            );
            $data['header'] = array(
                'title' => 'Add Employee',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Employee List' => route('admin.employee.list'),
                    'Add Employee' => 'Add Employee',
                )
            );
            return view('backend.pages.employee.add', $data);
        }else{
            return redirect()->route('admin.employee.list');
        }
    }

    public function saveAdd(Request $request)
    {
        $objEmployee = new Employee();

        $result = $objEmployee->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Employee details successfully added.';
            $return['redirect'] = route('admin.employee.list');
        } elseif ($result == "personal_gmail_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee personal gmail has already exists.';
        } elseif ($result == "personal_number_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee personal numbar has already exists.';
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function edit($editId)
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(76, explode(',', $permission_array[0]['permission']))){
            $objTechnology = new Technology();
            $data['technology'] = $objTechnology->get_admin_technology_details();

            $objDesignation = new Designation();
            $data['designation'] = $objDesignation->get_admin_designation_details();

            $objEmployee = new Employee();
            $data['employee_details'] = $objEmployee->get_employee_details($editId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Employee";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Employee";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Employee";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
                'pages/crud/file-upload/image-input.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'employee.js',
            );
            $data['funinit'] = array(
                'Employee.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Employee',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Employee List' => route('admin.employee.list'),
                    'Edit employee' => 'Edit employee',
                )
            );
            return view('backend.pages.employee.edit', $data);
        }else{
            return redirect()->route('admin.employee.list');
        }
    }

    public function saveEdit(Request $request)
    {
        $objemployee = new Employee();
        $result = $objemployee->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee details successfully updated.';
            $return['redirect'] = route('admin.employee.list');
        } elseif ($result == "employee_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee has already exists.';
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objEmployee = new Employee();
                $list = $objEmployee->getdatatable($request->input('data'));

                echo json_encode($list);
                break;

            case 'getbirthdaydatatable':
                $objEmployee = new Employee();
                $list = $objEmployee->getbirthdaydatatable($request->input('data'));

                echo json_encode($list);
                break;

            case 'getbondlastdatedatatable':
                $objEmployee = new Employee();
                $list = $objEmployee->getbondlastdatedatatable($request->input('data'));

                echo json_encode($list);
                break;

            case 'get_employee_details' :
                $inputData = $request->input('data');

                if($inputData['type'] == 'bank'){

                    $objEmployee = new Employee();
                    $data['employee_details'] = $objEmployee->get_employee_details($inputData['userId']);
                    $details =  view('backend.pages.employee.bank_info', $data);
                    echo $details;
                    break;

                } elseif($inputData['type'] == 'parent'){

                    $objEmployee = new Employee();
                    $data['employee_details'] = $objEmployee->get_employee_details($inputData['userId']);
                    $details =  view('backend.pages.employee.parent_info', $data);
                    echo $details;
                    break;

                } elseif($inputData['type'] == 'company'){

                    $objEmployee = new Employee();
                    $data['employee_details'] = $objEmployee->get_employee_details($inputData['userId']);
                    $details =  view('backend.pages.employee.company_info', $data);
                    echo $details;
                    break;

                } elseif($inputData['type'] == 'attendance'){
                    $data = $request->input('data');
                    $objAttendance = new Attendance();
                    $attendanceData = $objAttendance->get_attendance_details_by_employee($inputData['userId'],  $inputData['month'], $inputData['year']);
                    echo json_encode($attendanceData);
                    exit;

                }elseif($inputData['type'] == 'salary-slip'){
                    $objEmployee = new Employee();
                    $data['employee_details'] = $objEmployee->get_employee_details($inputData['userId']);
                    $details =  view('backend.pages.employee.salary_slip', $data);
                    echo $details;
                    break;


                } else {
                    $objEmployee = new Employee();
                    $data['employee_details'] = $objEmployee->get_employee_details($inputData['userId']);
                    $details =  view('backend.pages.employee.personal_info', $data);
                    echo $details;
                    break;
                }
            case 'common-activity':
                $data = $request->input('data');
                $objEmployee = new Employee();
                $result = $objEmployee->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Employee details successfully deleted.";
                    } elseif ($data['activity'] == 'active-records') {
                        $return['message'] = "Employee details successfully actived.";
                    } else {
                        $return['message'] = "Employee details successfully deactived.";
                    }
                    $return['redirect'] = route('admin.employee.list');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }

                echo json_encode($return);
                exit;
        }
    }

    public function view($viewId){

        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(75, explode(',', $permission_array[0]['permission']))){

            $objEmployee = new Employee();
            $data['employee_details'] = $objEmployee->get_employee_details($viewId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || View Employee";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || View Employee";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || View Employee";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
                'plugins/custom/fullcalendar/fullcalendar.bundle.css',
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
                'plugins/custom/fullcalendar/fullcalendar.bundle.js',

            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'employee.js',
            );
            $data['funinit'] = array(
                'Employee.view()',
            );
            $data['header'] = array(
                'title' => 'Basic Detail',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Employee List' => route('admin.employee.list'),
                    'View employee detail' => 'View employee detail',
                )
            );
            return view('backend.pages.employee.view', $data);
        }else{
            return redirect()->route('admin.employee.list');
        }
    }

    public function save_import(Request $request){


        $path = $request->file('file')->store('temp');
        $data = \Excel::import(new EmployeeImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Employee added successfully.';
        $return['redirect'] = route('admin.employee.list');

        echo json_encode($return);
        exit;
    }

    public function attendancelist(Request $request){

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Attendance List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Attendance List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Attendance List';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/datatables.bundle.css',
            'plugins/custom/fullcalendar/fullcalendar.bundle.css',
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/custom/datatables/datatables.bundle.js',
            'pages/crud/datatables/data-sources/html.js',
            'validate/jquery.validate.min.js',
            'plugins/custom/fullcalendar/fullcalendar.bundle.js',
            'pages/crud/forms/widgets/select2.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'attendance.js',
        );
        $data['funinit'] = array(
            'Attendance.init()',
        );
        $data['header'] = array(
            'title' => 'Attendance List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Attendance List' => 'Attendance List',
            )
        );
        return view('backend.pages.employee.attendance', $data);
    }

    public function offerLetterPdf($viewId){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(in_array(79, explode(',', $permission_array[0]['permission']))){

            $objEmployee = new Employee();
            $data['employee_details'] = $objEmployee->get_employee_details($viewId);

            $objCompanyinfo = new CompanyInfo();
            $data['systemDetails'] = $objCompanyinfo->get_system_details(1);

            $data['title'] = 'Offer Letter';

            $customPaper = [0, 0, 612.00, 792.00];
            $pdf = PDF::loadView('backend.pages.employee.offer_letter', $data)->setPaper($customPaper, 'portrait');

            return $pdf->download($data['employee_details']['first_name'].' '. $data['employee_details']['last_name'] .'_offer_letter.pdf');
        }else{
            return redirect()->route('my-dashboard');
        }
    }
    public function coverLetterPdf($viewId){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(in_array(80, explode(',', $permission_array[0]['permission']))){
            $objEmployee = new Employee();
            $data['employee_details'] = $objEmployee->get_employee_details($viewId);

            $objCompanyinfo = new CompanyInfo();
            $data['systemDetails'] = $objCompanyinfo->get_system_details(1);

            $data['title'] = 'Appoinment Letter';

            $customPaper = [0, 0, 612.00, 792.00];
            $pdf = PDF::loadView('backend.pages.employee.appoinment_letter', $data)->setPaper($customPaper, 'portrait');

            return $pdf->download($data['employee_details']['first_name'].' '. $data['employee_details']['last_name'] .'_appoinment_letter.pdf');
        }else{
            return redirect()->route('my-dashboard');
        }
    }
}
