@php
$currentRoute = Route::current()->getName();
// $userDetails = Auth()->guard('employee')->user();
// $permission_array = get_users_permission($userDetails['user_type']);
$data['systemDetails'] = get_system_details(1);
if(file_exists( public_path().'/upload/company_info/'.$data['systemDetails'][0]['logo']) &&$data['systemDetails'][0]['logo'] != ''){
    $logo = url("upload/company_info/".$data['systemDetails'][0]['logo']);
}else{
    $logo = url("upload/company_image/logo.png");
}

@endphp
<!--begin::Aside-->
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">
        <!--begin::Logo-->
        <a href="{{ route('my-dashboard.index') }}" class="brand-logo">
            {{-- <img alt="Logo" src="{{  asset('backend/media/logos/logo-light.png') }}" /> --}}
            <img width="100" height="50" alt="Logo" src="{{$logo }}" />
        </a>
        <!--end::Logo-->
        <!--begin::Toggle-->
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                        <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </button>
        <!--end::Toolbar-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav">
                <li class="menu-item  {{ ( $currentRoute  ==  "employee.edit-profile" || $currentRoute  ==  "employee.change-password" || $currentRoute  ==  "my-dashboard.index" ? 'menu-item-active' : '' ) }}" aria-haspopup="true">
                    <a href="{{ route('my-dashboard.index') }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                            <svg width="25" height="22" viewBox="0 0 25 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24.4826 10.8198L13.1237 0.240933C13.042 0.164557 12.9448 0.103965 12.8379 0.0626224C12.7309 0.0212801 12.6163 0 12.5005 0C12.3847 0 12.2701 0.0212801 12.1632 0.0626224C12.0562 0.103965 11.9591 0.164557 11.8773 0.240933L0.518442 10.8198C0.187522 11.1282 0 11.5471 0 11.984C0 12.8913 0.791451 13.629 1.76491 13.629H2.96174V21.1775C2.96174 21.6325 3.35608 22 3.84419 22H10.7356V16.2428H13.8242V22H21.1568C21.645 22 22.0393 21.6325 22.0393 21.1775V13.629H23.2361C23.7049 13.629 24.1544 13.4568 24.4853 13.1458C25.172 12.5032 25.172 11.4623 24.4826 10.8198Z" fill="white"/>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
</div>
<!--end::Aside-->
