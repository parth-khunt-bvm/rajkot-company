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
                        <form class="form" id="add-supplier" method="POST" action="{{ route('admin.supplier.save-add-supplier') }}" autocomplete="off">@csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Supplier Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Supplier Name" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Shop Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="shop_name" id="shop_name" placeholder="Shop Name" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Personal Contact
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control onlyNumber" name="personal_contact" id="personal_contact" placeholder="Supplier Name" autocomplete="off"  maxlength="10"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Shop Contact
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control onlyNumber" name="shop_contact" id="shop_contact" placeholder="Shop Name" autocomplete="off" maxlength="10"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="" cols="30" rows="3" name="address" id="address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Priority
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 priority" id="priority" name="priority">
                                                <option value="">Please select priority</option>
                                                <option value="0">Low</option>
                                                <option value="1">Medium</option>
                                                <option value="2">High</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Short Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control " name="short_name" id="short_name" placeholder="Short Name" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <div class="radio-inline" style="margin-top:10px">
                                                <label class="radio radio-lg radio-success" >
                                                <input type="radio" name="status" class="radio-btn" value="A" checked="checked"/>
                                                <span></span>Active</label>
                                                <label class="radio radio-lg radio-danger" >
                                                <input type="radio" name="status" class="radio-btn" value="I"/>
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
