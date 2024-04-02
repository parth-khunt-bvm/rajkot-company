@extends('backend.layout.app')
@section('section')

{{-- {{ $user_detail }} --}}
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">{{ $header['title'] }}</h3>
                    </div>
                     <!--begin::Form-->
                    <form class="form" id="edit-user" method="POST" action="{{ route('admin.user.save-edit-user') }}">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>First Name
                                        <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="first_name" class="form-control" value="{{ $user_detail['first_name'] }}" placeholder="Enter first name" autocomplete="off">
                                        <input type="hidden" name="userId" value="{{ $user_detail['id'] }}" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Last Name
                                        <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="last_name" class="form-control" value="{{ $user_detail['last_name'] }}" placeholder="Enter Last name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>User Type
                                        <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 user_role" id="user_role"  name="user_role">
                                            <option value="">Please select user type</option>
                                            @foreach ($userRole as $key => $value)
                                            <option value="{{ $value['id'] }}" {{ $value['id'] == $user_detail['user_type'] ? 'selected="selected"' : '' }}>{{ $value['user_role'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Branch Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 branch multipleSelection" id="branch"  name="branch[]" multiple>
                                            <option value="">Please select Branch Name</option>
                                            @foreach ($branch as $key => $value)
                                                <option value="{{ $value['id'] }}"
                                                    {{ in_array($value['id'], $user_branch->pluck('branch_id')->toArray()) ? 'selected="selected"' : '' }}>
                                                    {{ $value['branch_name'] }}
                                                </option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Email
                                        <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" name="email" class="form-control" value="{{ $user_detail['email'] }}" placeholder="Enter email" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <div class="radio-inline" style="margin-top:10px">
                                            <label class="radio radio-lg radio-success" >
                                            <input type="radio" name="status" class="radio-btn" value="A" {{ $user_detail->status == 'A' ? 'checked="checked"' : '' }}/>
                                            <span></span>Active</label>
                                            <label class="radio radio-lg radio-danger" >
                                            <input type="radio" name="status" class="radio-btn" value="I" {{ $user_detail->status == 'I' ? 'checked="checked"' : '' }}/>
                                            <span></span>Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card-->

            </div>

        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
@endsection
