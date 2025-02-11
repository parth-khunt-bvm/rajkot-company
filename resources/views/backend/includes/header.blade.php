<!--begin::Head-->
@php
    $data['systemDetails'] = get_system_details(1);
    if(file_exists( public_path().'/upload/company_info/'.$data['systemDetails'][0]['favicon']) &&$data['systemDetails'][0]['favicon'] != ''){
        $favicon = asset("upload/company_info/".$data['systemDetails'][0]['favicon']);
    }else{
        $favicon = asset('upload/company_image/favicon.jpg');
    }
@endphp

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}" />
    <meta name="keywords" content="{{ $keywords }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{  asset('backend/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{  asset('backend/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{  asset('backend/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{  asset('backend/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{  asset('backend/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{  asset('backend/css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{  asset('backend/css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    {{-- <link rel="shortcut icon" href="{{  asset('backend/media/logos/favicon.ico') }}" /> --}}
    <link rel="shortcut icon" href="{{ $favicon }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{  asset('backend/css/style.css') }}" rel="stylesheet" type="text/css" />
        @if (!empty($css))
            @foreach ($css as $value)
                @if(!empty($value))
                    <link rel="stylesheet" href="{{ asset('backend/css/customcss/'.$value) }}">
                @endif
            @endforeach
        @endif


        @if (!empty($plugincss))
            @foreach ($plugincss as $value)
                @if(!empty($value))
                    <link rel="stylesheet" href="{{ asset('backend/'.$value) }}">
                @endif
            @endforeach
        @endif


         @php
            $systemsetting = get_system_details();
            $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);
            $isAdmin = Auth()->guard('admin')->user()->is_admin;
            if(empty($permission_array)){
                $permission_array[0]['permission'] = null;
            }

         @endphp

            <style>
            </style>

         <script>
            var baseurl = "{{ asset('/') }}";
            var permission = "{{ $permission_array[0]['permission'] }}";
            var isAdmin = "{{ $isAdmin }}";
        </script>



</head>
<!--end::Head-->
