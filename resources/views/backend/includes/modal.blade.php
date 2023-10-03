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
            <div class="modal-body">
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
                                            <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>

                                    </div>
                                   <h5 class="text-danger">Note: Please remove the header from the excel sheet before importing the data.
                                     {{-- <a href="{{ url('public/upload/excel/demo.xlsx') }}" download><u>Download File <i class="fa fa-download" style="color: #3699FF !important" ></i></u></a> --}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                        <a href="{{ route('admin.branch.list') }}" class="btn btn-secondary">Cancel</a>

                    </div>
                </form>
            </div>
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
            <div class="modal-body">
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
                                            <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>

                                    </div>
                                   <h5 class="text-danger">Note: Please remove the header from the excel sheet before importing the data.
                                     {{-- <a href="{{ url('public/upload/excel/demo.xlsx') }}" download><u>Download File <i class="fa fa-download" style="color: #3699FF !important" ></i></u></a> --}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                        <a href="{{ route('admin.manager.list') }}" class="btn btn-secondary">Cancel</a>

                    </div>
                </form>
            </div>
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
            <div class="modal-body">
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
                                            <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>

                                    </div>
                                   <h5 class="text-danger">Note: Please remove the header from the excel sheet before importing the data.
                                     {{-- <a href="{{ url('public/upload/excel/demo.xlsx') }}" download><u>Download File <i class="fa fa-download" style="color: #3699FF !important" ></i></u></a> --}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                        <a href="{{ route('admin.technology.list') }}" class="btn btn-secondary">Cancel</a>

                    </div>
                </form>
            </div>
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
            <div class="modal-body">
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
                                            <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>

                                    </div>
                                   <h5 class="text-danger">Note: Please remove the header from the excel sheet before importing the data.
                                     {{-- <a href="{{ url('public/upload/excel/demo.xlsx') }}" download><u>Download File <i class="fa fa-download" style="color: #3699FF !important" ></i></u></a> --}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                        <a href="{{ route('admin.type.list') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
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
            <div class="modal-body">
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
                                            <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>

                                    </div>
                                   <h5 class="text-danger">Note: Please remove the header from the excel sheet before importing the data.
                                     {{-- <a href="{{ url('public/upload/excel/demo.xlsx') }}" download><u>Download File <i class="fa fa-download" style="color: #3699FF !important" ></i></u></a> --}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                        <a href="{{ route('admin.salary.list') }}" class="btn btn-secondary">Cancel</a>

                    </div>
                </form>
            </div>
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
            <div class="modal-body">
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
                                            <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>

                                    </div>
                                   <h5 class="text-danger">Note: Please remove the header from the excel sheet before importing the data.
                                     {{-- <a href="{{ url('public/upload/excel/demo.xlsx') }}" download><u>Download File <i class="fa fa-download" style="color: #3699FF !important" ></i></u></a> --}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                        <a href="{{ route('admin.expense.list') }}" class="btn btn-secondary">Cancel</a>

                    </div>
                </form>
            </div>
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
            <div class="modal-body">
                <form id="import-revenue" enctype="multipart/form-data" method="POST" action="{{ route('admin.revenue.save-import-revenue') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Upload Excel File<span class="text-danger">*</span></label>
                                        <div></div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="file" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>

                                    </div>
                                   <h5 class="text-danger">Note: Please remove the header from the excel sheet before importing the data.
                                     {{-- <a href="{{ url('public/upload/excel/demo.xlsx') }}" download><u>Download File <i class="fa fa-download" style="color: #3699FF !important" ></i></u></a> --}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2 submitbtn">Import Data</button>
                        <a href="{{ route('admin.revenue.list') }}" class="btn btn-secondary">Cancel</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


