@extends('backend.layout.app')
@section('section')
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
                        <form class="form" id="edit-manager" method="POST" action="{{ route('admin.manager.save-edit-manager') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Manager Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="manager_name"  class="form-control" placeholder="Enter manager name" value="{{ $manager_details->manager_name}}" autocomplete="off">
                                            <input type="hidden" name="manager_Id"  class="form-control" placeholder="Enter manager name" value="{{ $manager_details->id}}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <div class="radio-inline" style="margin-top:10px">
                                                <label class="radio radio-lg radio-success" >
                                                    <input type="radio" name="status" class="radio-btn" value="A" {{ $manager_details->status == 'A' ? 'checked="checked"' : '' }}/>
                                                    <span></span>Active</label>
                                                <label class="radio radio-lg radio-danger" >
                                                    <input type="radio" name="status" class="radio-btn" value="I" {{ $manager_details->status == 'I' ? 'checked="checked"' : '' }}/>
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
