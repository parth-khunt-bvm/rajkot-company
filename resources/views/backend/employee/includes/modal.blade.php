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

<!-- view public holiday Model-->
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
