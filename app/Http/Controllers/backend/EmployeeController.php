<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\EmployeeImport;
use App\Models\AssetAllocation;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\CompanyInfo;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\SalarySlip;
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

        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

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

            $objBranch = new Branch();
            $data['branch'] = $objBranch->get_admin_branch_details();

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
                'title' => 'ADD EMPLOYEE',
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
        } elseif ($result == "Employee_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee personal gmail has already exists.';
        } elseif ($result == "company_email_exits") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee company email has already exists.';
        } elseif ($result == "personal_email_exits") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee personal email has already exists.';
        } elseif ($result == "pan_number_exits") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee pan numbar has already exists.';
        } elseif ($result == "aadhar_card_number_exits") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'employee addhar card numbar has already exists.';
        } elseif ($result == "personal_number_exits") {
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

            $objBranch = new Branch();
            $data['branch'] = $objBranch->get_admin_branch_details();

            $objManager = new Manager();
            $data['manager'] = $objManager->get_admin_manager_details();

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
                'title' => 'EDIT EMPLOYEE',
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

    public function showDeletedData(Request $request)
    {
        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $objDesignation = new Designation();
        $data['designation'] = $objDesignation->get_admin_designation_details();

        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $objCompanyinfo = new CompanyInfo();
        $data['systemDetails'] = $objCompanyinfo->get_system_details(1);

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Employee Deleted list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Employee Deleted list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Employee Deleted list';
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
            'Employee.trash_init()'
        );
        $data['header'] = array(
            'title' => 'Employee Deleted list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Employee Deleted list' => 'Employee Deleted list',
            )
        );
        return view('backend.pages.employee.trash', $data);
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

            case 'get-employee-trash':
                $objEmployee = new Employee();
                $list = $objEmployee->getEmployeeDatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'add-branch-employee-import';
                $objBranch = new Branch();
                $list = $objBranch->get_admin_branch_details();
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

            case 'clear_cheque_image':
                $objEmployee = Employee::find($request->input('user_id'));
                
                $objEmployee->cancel_cheque = null;
                $objEmployee->save();

                echo json_encode($objEmployee->cancel_cheque == null);
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

                } elseif($inputData['type'] == 'asset-allocation'){

                    $objAssetAllocation = new AssetAllocation();
                    $assetAllocationData = $objAssetAllocation->get_asset_master_details($inputData['userId']);
                    // echo json_encode($assetAllocationData);
                    // break;
                    return $assetAllocationData;

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
                        $return['redirect'] = route('admin.employee.list');

                    } elseif ($data['activity'] == 'left-employee') {
                        $return['message'] = "Employee details successfully left.";
                        $return['redirect'] = route('admin.employee.list');

                    } elseif ($data['activity'] == 'restore-records') {
                        $return['message'] = "Employee details successfully restore.";
                        $return['redirect'] = route('admin.employee.deleted');

                    } else {
                        $return['message'] = "Employee details successfully working.";
                        $return['redirect'] = route('admin.employee.list');

                    }
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

            $objAssetAllocation = new AssetAllocation();
            $data['asset_allocations'] = $objAssetAllocation->get_asset_master_details($viewId);

            $objSalaryslip = new SalarySlip();
            $data['salary_slip_details'] = $objSalaryslip->get_salary_slip_details_for_employee($viewId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || View Employee";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || View Employee";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || View Employee";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
                'plugins/custom/fullcalendar/fullcalendar.bundle.css',
                'plugins/custom/datatables/datatables.bundle.css'
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
                'plugins/custom/fullcalendar/fullcalendar.bundle.js',
                'plugins/custom/datatables/datatables.bundle.js',
                'pages/crud/datatables/data-sources/html.js',

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
        $data = \Excel::import(new EmployeeImport($request->branch,$request->file('file')),$path);
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

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(79, explode(',', $permission_array[0]['permission']))){

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

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(80, explode(',', $permission_array[0]['permission']))){

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
