<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\SalarySlip;
use App\Models\Technology;
use Illuminate\Http\Request;
use Config;
use PDF;


class SalarySlipController extends Controller
{
    public function list(Request $request)
    {

        $objEmployee = new Employee();
        $data['employee'] = $objEmployee->get_admin_employee_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Salary Slip list';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Salary Slip list';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Salary Slip list';
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
            'pages/crud/forms/widgets/select2.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'salary_slip.js',
        );
        $data['funinit'] = array(
            'SalarySlip.init()',
            'SalarySlip.add()'
        );
        $data['header'] = array(
            'title' => 'Salary Slip list',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Salary Slip list' => 'Salary Slip list',
            )
        );
        return view('backend.pages.salary_slip.list', $data);

    }

    public function add()
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(127, explode(',', $permission_array[0]['permission']))){


            $objTechnology = new Technology();
            $data['technology'] = $objTechnology->get_admin_technology_details();

            $objDesignation = new Designation();
            $data['designation'] = $objDesignation->get_admin_designation_details();

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Salary Slip";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Salary Slip";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Salary Slip";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array();
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',

            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'salary_slip.js',
            );
            $data['funinit'] = array(
                'SalarySlip.add()'
            );
            $data['header'] = array(
                'title' => 'Add Salary Slip',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Salary Slip List' => route('admin.employee-salaryslip.list'),
                    'Add Salary Slip' => 'Add Salary Slip',
                )
            );
            return view('backend.pages.salary_slip.add', $data);

        }else{
            return redirect()->route('admin.employee-salaryslip.list');
        }
    }

    public function saveAdd(Request $request)
    {
        $objSalarySlip = new SalarySlip();
        $result = $objSalarySlip->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary Slip details successfully added.';
            $return['redirect'] = route('admin.employee-salaryslip.list');
        } elseif ($result == "salary_slip_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary Slip has already exists.';
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

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(129, explode(',', $permission_array[0]['permission']))){

            $objSalaryslip = new SalarySlip();
            $data['salary_slip_details'] = $objSalaryslip->get_salary_slip_details($editId);

            $objTechnology = new Technology();
            $data['technology'] = $objTechnology->get_admin_technology_details();

            $objDesignation = new Designation();
            $data['designation'] = $objDesignation->get_admin_designation_details();

            $objEmployee = new Employee();
            $data['employee'] = $objEmployee->get_employee_salary_slip_detail($data['salary_slip_details']['department'], $data['salary_slip_details']['designation']);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Edit Salary Slip";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Edit Salary Slip";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Edit Salary Slip";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array();
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'salary_slip.js',
            );
            $data['funinit'] = array(
                'SalarySlip.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit salary Slip',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Salary Slip List' => route('admin.employee-salaryslip.list'),
                    'Edit salary Slip' => 'Edit salary Slip',
                )
            );
            return view('backend.pages.salary_slip.edit', $data);

        }else{
            return redirect()->route('admin.employee-salaryslip.list');
        }

    }

    public function saveEdit(Request $request)
    {
        $objSalarySlip = new SalarySlip();
        $result = $objSalarySlip->saveEdit($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary Slip details successfully updated.';
            $return['redirect'] = route('admin.employee-salaryslip.list');
        } elseif ($result == "salary_slip_exists") {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Salary Slip has already exists.';
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    public function view($viewId){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(128, explode(',', $permission_array[0]['permission']))){

            $objSalaryslip = new SalarySlip();
            $data['salary_slip_details'] = $objSalaryslip->get_salary_slip_details($viewId);

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || View Salary Slip";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || View Salary Slip";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || View Salary Slip";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array();
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'salary_slip.js',
            );
            $data['funinit'] = array(
            );
            $data['header'] = array(
                'title' => 'Basic Detail',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Salary Slip List' => route('admin.employee-salaryslip.list'),
                    'View salary slip detail' => 'View salary slip detail',
                )
            );
            return view('backend.pages.salary_slip.view', $data);
        }else{
            return redirect()->route('admin.employee-salaryslip.list');
        }
    }


    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objSalarySlip = new SalarySlip();
                $list = $objSalarySlip->getdatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'get-employee-detail':
                $data = $request->input('data');
                $objEmployee = new Employee();
                $list = $objEmployee->get_employee_salary_slip_detail($data['department'], $data['designation'] );
                echo json_encode($list);
                break;

            case 'common-activity':
                $data = $request->input('data');
                $objSalarySlip = new SalarySlip();
                $result = $objSalarySlip->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if ($data['activity'] == 'delete-records') {
                        $return['message'] = "Salary slip details successfully deleted.";
                    }
                    $return['redirect'] = route('admin.employee-salaryslip.list');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';;
                }

                echo json_encode($return);
                exit;
        }
    }

    public function salarySlipPdf($salarySlipId){
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(131, explode(',', $permission_array[0]['permission']))){
            $month= ["","January","February","March","April","May","June","July","August","September","October","November","December"];
            $objSalaryslip = new SalarySlip();
            $data['salary_slip_details'] = $objSalaryslip->get_salary_slip_details($salarySlipId);
            $salarySlipDetails = $data['salary_slip_details'] ;

            $data['title'] = 'Salary Slip';

            $pdf = PDF::loadView('backend.pages.salary_slip.pdf', $data);

            return $pdf->download($salarySlipDetails->first_name.' '.$salarySlipDetails->last_name.' - '. $month[$salarySlipDetails->month] . ' , ' .$salarySlipDetails->year.'.pdf');
        }else{
            return redirect()->route('my-dashboard');
        }
    }

}
