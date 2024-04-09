<style>
    .select2 {
        width: 100% !important;
    }

</style>
<div class="modal fade " id="viewAuditTrails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Audit Trails Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="view-audit-trails" style="word-break: break-all !important; ">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="activeModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Active record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <p> Are you sure you want to active record ? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light yes-sure-active">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="deactiveModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deactive record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <p> Are you sure you want to deactive record ? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light yes-sure-deactive">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div>

<!-- Employee status-->
<div class="modal fade" id="workingModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Working Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <p> Are you sure you want to working employee? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light yes-sure-active">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div>

<!-- Employee status-->
<div class="modal fade" id="leftModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Left Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <p> Are you sure you want to left employee ? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light yes-sure-deactive">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <p> Are you sure you want to delete record ? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light yes-sure">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div>

<!-- Import Branch Model-->
<div class="modal fade" id="importBranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-branch" enctype="multipart/form-data" method="POST" action="{{ route('admin.branch.save-import-branch') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.branch.list') }}" class="btn btn-secondary">Cancel</a>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Manager Model-->
<div class="modal fade" id="importManager" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Manager</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-manager" enctype="multipart/form-data" method="POST" action="{{ route('admin.manager.save-import-manager') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.manager.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Technology Model-->
<div class="modal fade" id="importTechnology" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Technology</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-technology" enctype="multipart/form-data" method="POST" action="{{ route('admin.technology.save-import-technology') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.technology.list') }}" class="btn btn-secondary">Cancel</a>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- Import Type Model-->
<div class="modal fade" id="importType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-type" enctype="multipart/form-data" method="POST" action="{{ route('admin.type.save-import-type') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.type.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Salary Model-->
<div class="modal fade" id="importSalary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Salary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-salary" enctype="multipart/form-data" method="POST" action="{{ route('admin.salary.save-import-salary') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.salary.list') }}" class="btn btn-secondary">Cancel</a>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Expense Model-->
<div class="modal fade" id="importExpense" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-expense" enctype="multipart/form-data" method="POST" action="{{ route('admin.expense.save-import-expense') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.expense.list') }}" class="btn btn-secondary">Cancel</a>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Revenue Model-->
<div class="modal fade" id="importRevenue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Revenue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-revenue" enctype="multipart/form-data" method="POST" action="{{ route('admin.revenue.save-import-revenue') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <a style="text-align: center;" href="{{ asset('upload/excel/revenue1.csv')}}" download="revenue1.csv"><u>Download File <i class="fa fa-download" style="color: #3699FF !important" ></i></u></a>
                                    <a style="text-align: center;" href="{{ asset('upload/excel/revenue2.csv')}}" download="revenue2.csv"><u>Download File <i class="fa fa-download" style="color: #3699FF !important" ></i></u></a>
                                    <a style="text-align: center;" href="{{ asset('upload/excel/revenue3.csv')}}" download="revenue3.csv"><u>Download File <i class="fa fa-download" style="color: #3699FF !important" ></i></u></a>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.revenue.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Employee Model-->
<div class="modal fade" id="importEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-employee" enctype="multipart/form-data" method="POST" action="{{ route('admin.employee.save-import-employee') }}">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Branch Name
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 branch" id="branchId" name="branch">
                                    <option value="">Please select Branch Name</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Import Counter Model-->
<div class="modal fade" id="importCounter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Counter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-counter" enctype="multipart/form-data" method="POST" action="{{ route('admin.counter.save-import-counter') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Month</label><br>
                                <select class="form-control select2 month change" id="month" name="month">
                                    <option value="">Select Month</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>year</label><br>
                                <select class="form-control select2 year change" id="year" name="year">
                                    <option value="">Select Year</option>
                                    @for ($i = 2019; $i <= date('Y'); $i++) <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Upload Excel File<span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.counter.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Salary Not Counted Model-->
<div class="modal fade" id="salaryNotCounted" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Salary Not Counted</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <p> Are you sure you want to not counted salary ? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light yes-sure-not-counted">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div>

<!-- Salary Counted Model-->
<div class="modal fade" id="salaryCounted" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Salary Counted</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <p> Are you sure you want to counted salary ? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light yes-sure-counted">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div>

<!-- Import Type Model-->
<div class="modal fade " id="addType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="add-type-modal" method="POST" action="{{ route('admin.type.save-add-type') }}">@csrf
                    <div class="card-body">
                        <div id="addTypeDiv">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Type name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="type_name[]" class="form-control typeinput" placeholder="Enter type name">
                                        <span class="type_error text-danger"></span>
                                    </div>
                                </div>

                                <div class="col-md-2 padding-left-5 padding-right-5">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <a href="javascript:;" class="my-btn btn btn-success add-type-button"><i class="my-btn fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <div class="radio-inline" style="margin-top:10px">
                                        <label class="radio radio-lg radio-success">
                                            <input type="radio" name="status" class="radio-btn" value="A" checked="checked" />
                                            <span></span>Active</label>
                                        <label class="radio radio-lg radio-danger">
                                            <input type="radio" name="status" class="radio-btn" value="I" />
                                            <span></span>Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Import Designation Model-->
<div class="modal fade" id="importDesignation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Designation </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-designation" enctype="multipart/form-data" method="POST" action="{{ route('admin.designation.save-import-designation') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.designation.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Hr Income Model-->
<div class="modal fade" id="importHrIncome" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Hr Income</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-hr-income" enctype="multipart/form-data" method="POST" action="{{ route('admin.hr.income.save-import-income') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.hr.income.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Hr Expense Model-->
<div class="modal fade" id="importHrExpense" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Hr Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-hr-expense" enctype="multipart/form-data" method="POST" action="{{ route('admin.hr.expense.save-import-expense') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.hr.expense.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import User Role Model-->
<div class="modal fade" id="importUserRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import User Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-user-role" enctype="multipart/form-data" method="POST" action="{{ route('admin.user-role.save-import-type') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.user-role.add') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import public holiday Model-->
<div class="modal fade" id="import-public-holiday" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Public holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="import-public-holidays" enctype="multipart/form-data" method="POST" action="{{ route('admin.public-holiday.save-import-public-holiday') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Upload Excel File<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                    <a href="{{ route('admin.branch.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- view Supplier Model-->
<div class="modal fade" id="supplier-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-5 mr-5 ml-5">
                    <div class="col-4">
                        <b>Supplier Name</b> <br>
                        <span id="md_supplier_name"></span>
                    </div>
                    <div class="col-4">
                        <b>Shop Name</b> <br>
                        <span id="md_shop_name"></span>

                    </div>
                    <div class="col-4">
                        <b>Shop Contact</b> <br>
                        <span id="md_shop_contact"></span>

                    </div>
                </div>

                <div class="row mt-5 mr-5 mb-5 ml-5">
                    <div class="col-4">
                        <b>Personal Contact</b> <br>
                        <span id="md_personal_contact"></span>
                    </div>
                    <div class="col-4">
                        <b>Priority</b> <br>
                        <span id="md_priority"></span>
                    </div>
                    <div class="col-4">
                        <b>Short Name</b> <br>
                        <span id="md_short_name"></span>
                    </div>
                </div>

                <div class="row mt-5 mr-5 mb-5 ml-5">
                    <div class="col-4">
                        <b>Status</b> <br>
                        <span id="md_status"></span>
                    </div>
                    <div class="col-4">
                        <b>Address</b> <br>
                        <span id="md_address"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- view Asset Master Model-->
<div class="modal fade" id="asset-master-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Asset Master</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-5 mr-5 ml-5">
                    <div class="col-4">
                        <b>Supplier Name</b> <br>
                        <span id="as_supplier_name"></span>
                    </div>
                    <div class="col-4">
                        <b>Asset Name</b> <br>
                        <span id="as_asset_name"></span>
                    </div>
                    <div class="col-4">
                        <b>Branch Name</b> <br>
                        <span id="as_branch_name"></span>
                    </div>
                </div>

                <div class="row mt-5 mr-5 mb-5 ml-5">
                    <div class="col-4">
                        <b>Brand Name</b> <br>
                        <span id="as_brand_name"></span>
                    </div>
                    <div class="col-4">
                        <b>Price</b> <br>
                        <span id="as_price"></span>
                    </div>
                    <div class="col-4">
                        <b>Status</b> <br>
                        <span id="as_status"></span>
                    </div>
                </div>

                <div class="row mt-5 mr-5 mb-5 ml-5">
                    <div class="col-4">
                        <b>Description</b> <br>
                        <span id="as_description"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- view public holiday Model-->
<div class="modal fade" id="public-holiday-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Public Holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-5 mr-5 ml-5">
                    <div class="col-4">
                        <b>Date</b> <br>
                        <span id="holiday_date"></span>
                    </div>
                    <div class="col-4">
                        <b>Holiday Name</b> <br>
                        <span id="holiday_name"></span>

                    </div>
                    <div class="col-4">
                        <b>Note</b> <br>
                        <span id="holiday_note"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- view leave request Model-->
<div class="modal fade" id="admin-leave-request-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Leave Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-5 mr-5 ml-5">
                    <div class="col-3">
                        <b>Date</b> <br>
                        <span id="leave_date"></span>
                    </div>
                    <div class="col-3">
                        <b>Employee Name</b> <br>
                        <span id="leave_emp_name"></span>

                    </div>
                    <div class="col-3">
                        <b>Manager Name</b> <br>
                        <span id="leave_man_name"></span>
                    </div>
                    <div class="col-3">
                        <b>Leave Type</b> <br>
                        <span id="leeave_type"></span>
                    </div>
                </div>
                <div class="row mt-5 mr-5 ml-5">
                    <div class="col-3">
                        <b>Leave Status</b> <br>
                        <span id="leave_status"></span>
                    </div>
                    <div class="col-3">
                        <b>Leave Reason</b> <br>
                        <span id="leave_reason"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import Type Model-->
<div class="modal fade" id="admin-leave-request-reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reject Leave Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="reject-leave-reuest" method="POST" action="{{ route('admin.reject-leave-request') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" class="leave-request-id" name="id">
                            <div class="form-group">
                                <label>Reason <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="" cols="30" rows="2" name="reason" id="reason"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Submit</button>
                    <a href="{{ route('admin.leave-request.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="leave-request-approved" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Approved Leave Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <p> Are you sure you want to Approved Leave Request ? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light yes-approved">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div>

<!-- view employee Overtime Model-->
<div class="modal fade" id="emp-overtime-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Employee Overtime</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-5 mr-5 ml-5">
                    <div class="col-3">
                        <b>Date</b> <br>
                        <span id="overtime_date"></span>
                    </div>
                    <div class="col-3">
                        <b>Employee Name</b> <br>
                        <span id="overtime_employee"></span>

                    </div>
                    <div class="col-3">
                        <b>Hours</b> <br>
                        <span id="overtime_hours"></span>
                    </div>
                    <div class="col-3">
                        <b>Note</b> <br>
                        <span id="overtime_note"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- CounterSheet Calender Model-->
<div class="modal fade" id="counter-sheet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Employee Calender</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="counter-sheet-view-model"></div>
            </div>
        </div>
    </div>
</div>

<!-- send and create salary slip Model-->
<div class="modal fade" id="send-create-salary-slip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send and Create Salary Slip</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="send-create-salary-slip-form" enctype="multipart/form-data" method="POST" action="{{ route('admin.employee-salaryslip.create-employee-salaryslip') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Employee Name
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control employee select2" name="employee" id="employee">
                                    <option value="">Select Employee </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Month</label><br>
                                <select class="form-control select2 month change-fillter" id="monthId"  name="month">
                                    <option value="">Select Month</option>
                                    <option value="1" {{  date('n') == 1 ? 'selected="selected"' : '' }} >January</option>
                                    <option value="2" {{  date('n') == 2 ? 'selected="selected"' : '' }} >February</option>
                                    <option value="3" {{  date('n') == 3 ? 'selected="selected"' : '' }} >March</option>
                                    <option value="4" {{  date('n') == 4 ? 'selected="selected"' : '' }} >April</option>
                                    <option value="5" {{  date('n') == 5 ? 'selected="selected"' : '' }} >May</option>
                                    <option value="6" {{  date('n') == 6 ? 'selected="selected"' : '' }} >June</option>
                                    <option value="7" {{  date('n') == 7 ? 'selected="selected"' : '' }} >July</option>
                                    <option value="8" {{  date('n') == 8 ? 'selected="selected"' : '' }} >August</option>
                                    <option value="9" {{  date('n') == 9 ? 'selected="selected"' : '' }} >September</option>
                                    <option value="10" {{  date('n') == 10 ? 'selected="selected"' : '' }} >October</option>
                                    <option value="11" {{  date('n') == 11 ? 'selected="selected"' : '' }} >November</option>
                                    <option value="12" {{  date('n') == 12 ? 'selected="selected"' : '' }} >December</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>year</label><br>
                                <select class="form-control select2 year change-fillter" id="yearId"  name="year">
                                    <option value="">Select Year</option>
                                    @for ($i = 2019; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{ $i == date('Y') ? 'selected="selected"' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mr-2 submitbtn">Send and Create</button>
                    <a href="{{ route('admin.employee-salaryslip.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- view leave request Model-->

{{-- <div class="modal fade " id="change-request-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">change request view</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Old Data</h5>
                        <div id="old-data">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>New Data</h5>
                        <div id="new-data">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary mr-2 submitbtn">Approved</button>
                <button type="button" class="btn btn-primary waves-effect waves-light yes-sure">Rejected</button>
                <button type="button" class="btn btn-primary waves-effect waves-light yes-sure-deactive">Yes , I am sure</button>
            </div>
        </div>
    </div>
</div> --}}

<!-- Modal-->
<div class="modal fade" id="changeRequestModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Old Data</h5>
                        <div id="old-data">
                            <!-- Old Data will be displayed here -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>New Data</h5>
                        <div id="new-data">
                            <!-- New Data will be displayed here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect waves-light yes-sure-approved">Approved</button>
                <button type="button" class="btn btn-primary waves-effect waves-light yes-sure">Rejected</button>
            </div>
        </div>
    </div>
</div>





