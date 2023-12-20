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
                        <form class="form" id="edit-supplier" method="POST" action="{{ route('admin.supplier.save-edit-supplier') }}" autocomplete="off">@csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Supplier Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="hidden" name="supplier_id" class="form-control" value="{{ $supplier_details->id}}">
                                            <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Supplier Name" value="{{ $supplier_details->suppiler_name }}" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Shop Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="shop_name" id="shop_name" placeholder="Shop Name" value="{{ $supplier_details->supplier_shop_name }}" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Personal Contact
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="personal_contact" id="personal_contact" placeholder="Supplier Name" value="{{ $supplier_details->personal_contact }}" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Shop Contact
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="shop_contact" id="shop_contact" placeholder="Shop Name" value="{{ $supplier_details->shop_contact }}" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="" cols="30" rows="10" name="address" id="address">{{ $supplier_details->address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Priority
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 priority" id="priority" name="priority">
                                                <option value="">Please select priority</option>
                                                <option value="0" {{ $supplier_details->priority == 0 ? 'selected="selected"' : '' }}>Low</option>
                                                <option value="1" {{ $supplier_details->priority == 1 ? 'selected="selected"' : '' }}>Normal</option>
                                                <option value="2" {{ $supplier_details->priority == 2 ? 'selected="selected"' : '' }}>Hogh</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <div class="radio-inline" style="margin-top:10px">
                                                <label class="radio radio-lg radio-success" >
                                                <input type="radio" name="status" class="radio-btn" value="A" {{ $supplier_details->status == 'A' ? 'checked="checked"' : '' }}/>
                                                <span></span>Active</label>
                                                <label class="radio radio-lg radio-danger" >
                                                <input type="radio" name="status" class="radio-btn" value="I" {{ $supplier_details->status == 'I' ? 'checked="checked"' : '' }}/>
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
