@extends('backend.layout.app')
@section('section')
@php
$currentRoute = Route::current()->getName();
if (!empty(Auth()->guard('admin')->user())) {
   $data = Auth()->guard('admin')->user();
}
if(file_exists( public_path().'/upload/company_info/'.$systemDetails[0]['signature']) &&$systemDetails[0]['signature'] != ''){
    $signature = url("upload/company_info/".$systemDetails[0]['signature']);
}else{
    $signature = url("upload/company_image/sign.png");
}

if(file_exists( public_path().'/upload/company_info/'.$systemDetails[0]['logo']) &&$systemDetails[0]['logo'] != ''){
    $logo = url("upload/company_info/".$systemDetails[0]['logo']);
}else{
    $logo = url("upload/company_image/logo.png");
}

if(file_exists( public_path().'/upload/company_info/'.$systemDetails[0]['favicon']) &&$systemDetails[0]['favicon'] != ''){
    $favicon_icon  = url("upload/company_info/".$systemDetails[0]['favicon'] );
}else{
    $favicon_icon  = url("upload/company_image/favicon.jpg");
}

@endphp
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
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
                    <form class="form" id="system-setting" method="POST" action="{{ route('system-color-setting.save-add') }}">@csrf
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Logo</label>
                                        <div class="">
                                            <div class="image-input image-input-outline" id="kt_image_2">
                                                <div class="image-input-wrapper" style="background-image: url({{ $logo }})"></div>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change Business Logo">
                                                    <i class="fa fa-pencil icon-sm text-muted"></i>
                                                    <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="profile_avatar_remove" />
                                                </label>
                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Business Favicon Icon">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Business Favicon Icon</label>
                                        <div class="">
                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                <div class="image-input-wrapper" style="background-image: url({{ $favicon_icon }})"></div>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change Business Favicon Icon">
                                                    <i class="fa fa-pencil icon-sm text-muted"></i>
                                                    <input type="file" name="favicon" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="profile_avatar_remove" />
                                                </label>
                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Business Favicon Icon">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>signature</label>
                                        <div class="">
                                            <div class="image-input image-input-outline" id="kt_image_3">
                                                <div class="image-input-wrapper" style="background-image: url({{ $signature }})"></div>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change signture Image">
                                                    <i class="fa fa-pencil icon-sm text-muted"></i>
                                                    <input type="file" name="signature" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="profile_avatar_remove" />
                                                </label>
                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Business Favicon Icon">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2 submitbtn">Submit</button>
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
    <!--end::Container-->
</div>
<!--end::Entry-->
@endsection
