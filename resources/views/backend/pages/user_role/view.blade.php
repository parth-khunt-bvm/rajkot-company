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
                        <div class="row mt-5 mr-5 ml-5 mb-5" >
                            <div class="col-3">
                                <b>User Role</b> <br>
                                 {{ $user_role_details->user_role }}
                            </div>
                            <div class="col-3">
                                <b>Status</b> <br>
                                @if ($user_role_details->status == 'A')
                                    Active
                                @else
                                    Inactive
                                @endif
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
