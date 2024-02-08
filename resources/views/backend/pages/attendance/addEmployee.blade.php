<div class="row removediv">
    <div class="col-md-3">
        <div class="form-group">
            <label>Absent Employee
                <span class="text-danger">*</span>
            </label>
            <select class="form-control select2 employee_id employee_select" name="employee_id[]">
                <option value="">Please select Employee Name</option>
                @foreach ($employeeList as $key => $value )
                <option value="{{ $value['id'] }}">{{ $value['first_name'] . ' ' . $value['last_name']}}</option>
                @endforeach
            </select>
            <span class="attendance_error text-danger"></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Leave Type
                <span class="text-danger">*</span>
            </label>
            <select class="form-control select2 leave_type leave_select"  name="leave_type[]">
                <option value="">Please select Leave Type</option>
                <option value="0">Present</option>
                <option value="1">Full Day Leave</option>
                <option value="2">Half Day Leave</option>
                <option value="3">Sort Leave</option>
            </select>
            <span class="leave_error text-danger"></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Reson</label>
            <textarea class="form-control" id="" cols="30" rows="1" name="reason[]" id="reason"></textarea>
        </div>
    </div>
    <div class="col-md-2 padding-left-5 padding-right-5">
        <div class="form-group">
            <label>&nbsp;</label><br>
            <a href="javascript:;" class="my-btn btn btn-success add-attendance-button"><i class="my-btn fa fa-plus"></i></a>
            <a href="javascript:;" class="my-btn btn btn-danger remove-attendance ml-2"><i class="my-btn fa fa-minus"></i></a>
        </div>
    </div>
</div>
