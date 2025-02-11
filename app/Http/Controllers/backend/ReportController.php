<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Manager;
use App\Models\Revenue;
use App\Models\Salary;
use App\Models\Technology;
use App\Models\Type;
use Config;

class ReportController extends Controller
{
    public function expense()
    {
        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $objType = new Type();
        $data['type'] = $objType->get_admin_type_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Expense Reports';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Expense Reports';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Expense Reports';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
        );
        $data['js'] = array(
            'expensereport.js',
        );
        $data['funinit'] = array(
            'Expensereport.init()',
        );
        $data['header'] = array(
            'title' => 'Expense Reports',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Expense Reports' => 'Expense Reports',
            )
        );
        return view('backend.pages.report.expense', $data);

    }

    public function revenue()
    {
        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Revenue Reports';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Revenue Reports';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Revenue Reports';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
        );
        $data['js'] = array(
            'report.js',
        );
        $data['funinit'] = array(
            'Report.revenue()',
        );
        $data['header'] = array(
            'title' => 'Revenue Reports',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Revenue Reports' => 'Revenue Reports',
            )
        );
        return view('backend.pages.report.revenue', $data);

    }
    public function salary()
    {
        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $objManager = new Manager();
        $data['manager'] = $objManager->get_admin_manager_details();

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Salary Reports';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Salary Reports';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Salary Reports';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
        );
        $data['js'] = array(
            'report.js',
        );
        $data['funinit'] = array(
            'Report.salary()',
        );
        $data['header'] = array(
            'title' => 'Salary Reports',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Salary Reports' => 'Salary Reports',
            )
        );
        return view('backend.pages.report.salary', $data);

    }

    public function profitLoss()
    {
        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $objType = new Type();
        $data['type'] = $objType->get_admin_type_details();

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Profit-loss Reports';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Profit-loss Reports';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Profit-loss Reports';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
        );
        $data['js'] = array(
            'report.js',
        );
        $data['funinit'] = array(
            'Report.profitLoss()',
        );
        $data['header'] = array(
            'title' => 'Profit and Loss Reports',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Profit-Loss Reports' => 'Profit-loss Reports',
            )
        );
        return view('backend.pages.report.profit_loss', $data);

    }

    public function profitLossByTime()
    {
        $objBranch = new Branch();
        $data['branch'] = $objBranch->get_admin_branch_details();

        $objType = new Type();
        $data['type'] = $objType->get_admin_type_details();

        $objTechnology = new Technology();
        $data['technology'] = $objTechnology->get_admin_technology_details();

        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Profit-loss-by-time Reports';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Profit-loss-by-time Reports';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Profit-loss-by-time Reports';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
        );
        $data['js'] = array(
            'report.js',
        );
        $data['funinit'] = array(
            'Report.profitLossByTime()',
        );
        $data['header'] = array(
            'title' => 'Profit and loss by time Reports',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Profit-loss Reports' => 'Profit-loss-by_time Reports',
            )
        );
        return view('backend.pages.report.profit_loss_by_time', $data);

    }

    public function ajaxcall(Request $request){
        $action = $request->input('action');
        $data = $request->input('data');
        switch ($action) {
            case 'get-expense-reports-data' :
                $objExpense = new Expense();
                $list = $objExpense->getExpenseReportsData($data);
                echo json_encode($list);
                break;

            case 'get-expense-reports-data-quarterly' :
                $objExpense = new Expense();
                $list = $objExpense->getExpenseDataQuarterly($data);
                echo json_encode($list);
                break;

            case 'get-revenue-reports-data' :
                $objRevenue = new Revenue();
                $list = $objRevenue->getRevenueReportsData($data);
                echo json_encode($list);
                break;

            case 'get-salary-reports-data' :
                $objSalary = new Salary();
                $list = $objSalary->getSalaryReportsData($data);
                echo json_encode($list);
                break;

            case 'get-profit-loss-reports-data' :
                $objSalary = new Salary();
                $list = $objSalary->getProfitLossReportsData($data);
                echo json_encode($list);
                break;

            case 'get-expense-by-time-reports-data' :
                $objSalary = new Salary();
                $list = $objSalary->getProfitLossByTimeReportsData($data);
                echo json_encode($list);
                break;

            case 'get-expense-by-time-reports-data-annually' :
                $objSalary = new Salary();
                $list = $objSalary->getProfitLossByTimeReportsDataAnnually($data);
                echo json_encode($list);
                break;

            case 'get-expense-by-time-reports-data-monthly' :
                $objSalary = new Salary();
                $list = $objSalary->getProfitLossByTimeReportsDataMonthly($data);
                echo json_encode($list);
                break;

            case 'getProfitLossByTimeReportsDataSemiAnnually' :
                $objSalary = new Salary();
                $list = $objSalary->getProfitLossByTimeReportsDataSemiAnnually($data);
                echo json_encode($list);
                break;

            case 'getProfitLossByTimeReportsDataQuarterly' :
                $objSalary = new Salary();
                $list = $objSalary->getProfitLossByTimeReportsDataQuarterly($data);
                echo json_encode($list);
                break;
        }
    }
}
