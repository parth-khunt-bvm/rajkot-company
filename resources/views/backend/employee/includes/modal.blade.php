<style>
    .select2 {
        width: 100% !important;
    }

</style>

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

<!-- view leave request Model-->
<div class="modal fade" id="leave-request-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <b>Start Date</b> <br>
                        <span id="leave_start_date"></span>
                    </div>
                    <div class="col-3">
                        <b>End Date</b> <br>
                        <span id="leave_end_date"></span>
                    </div>
                    <div class="col-3">
                        <b>Employee Name</b> <br>
                        <span id="leave_emp_name"></span>

                    </div>
                    <div class="col-3">
                        <b>Manager Name</b> <br>
                        <span id="leave_man_name"></span>
                    </div>
                </div>
                <div class="row mt-5 mr-5 ml-5">
                    <div class="col-3">
                        <b>Leave Type</b> <br>
                        <span id="leaveType"></span>
                    </div>
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

<!-- The Image Preview Modal -->
<div id="imagePreviewModal" class="previewModal">
    <span class="imagePreviewClose">&times;</span>
    <img class="imgPreview-modal-content" id="previewModalImage">
</div>

<!-- The Watch Password Modal -->
<div class="modal fade" id="unmask-pass-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enter Login Credential</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="{{ route('employee.save-profile.ajaxcall') }}" method="POST" id="viewPassForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Login Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" name="login_email" id="login_email" placeholder="Login Email">
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Login Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control" name="login_password" id="login_password" placeholder="Login Password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light unhashPass">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>