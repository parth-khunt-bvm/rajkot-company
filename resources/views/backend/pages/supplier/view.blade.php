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
                        <div class="row mt-5 mr-5 ml-5" >
                            <div class="col-3">
                                <b>Supplier Name</b> <br>
                                 {{ $supplier_details->suppiler_name }}
                            </div>
                            <div class="col-3">
                                <b>Shop Name</b> <br>
                                 {{ $supplier_details->supplier_shop_name }}
                            </div>
                            <div class="col-3">
                                <b>Shop Contact</b> <br>
                                 {{ $supplier_details->shop_contact }}
                            </div>
                            <div class="col-3">
                                <b>Personal Contact</b> <br>
                                 {{ $supplier_details->personal_contact }}
                            </div>
                        </div>

                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>Priority</b> <br>
                                @if($supplier_details->priority == "0")
                                        Low
                                @elseif ($supplier_details->priority == "1")
                                        medium
                                @elseif ($supplier_details->priority == "2")
                                        high
                                @endif
                            </div>
                            <div class="col-3">
                                <b>Short Name</b> <br>
                                 {{ $supplier_details->sort_name }}
                            </div>
                            <div class="col-3">
                                <b>Status</b> <br>
                                 {{ $supplier_details->status }}
                            </div>
                            <div class="col-3">
                                <b>Address</b> <br>
                                 {{ $supplier_details->address }}
                            </div>
                        </div>

                    </div>
                    <!--end::Card-->
                </div>

            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
