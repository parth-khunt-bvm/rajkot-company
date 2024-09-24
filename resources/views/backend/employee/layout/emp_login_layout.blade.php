<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>{{ $title }}</title>
		<meta name="description" content="{{ $description }}" />
		<meta name="keywords" content="{{ $keywords }}" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="{{  Config::get('constants.SYSTEM_NAME') }}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="{{  asset('backend/css/pages/login/classic/login-5.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
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
		<link rel="shortcut icon" href="{{  asset('upload/system/favicon.png') }}" />
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


        <script>
            var baseurl = "{{ asset('/') }}";
            var date_formate = "dd-M-yyyy";
            var decimal_point = "{{ Config::get('constants.DECIMAL_POINT') }}";
        </script>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

        @yield('section')

		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "var(--theme-color)", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{  asset('backend/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{  asset('backend/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
		<script src="{{  asset('backend/js/scripts.bundle.js') }}"></script>
		<!--end::Global Theme Bundle-->

        <div id="loader"></div>

		<script src="{{ asset('backend/js/pages/jquery/jquery.min.js') }}"></script>


        @if (!empty($pluginjs))
			@foreach ($pluginjs as $value)
				<script src="{{ asset('backend/js/'.$value) }}" type="text/javascript"></script>
			@endforeach
		@endif

		@if (!empty($js))
		@foreach ($js as $value)
			<script src="{{ asset('backend/js/customjs/'.$value) }}" type="text/javascript"></script>
		@endforeach
		@endif
		<script type="text/javascript">
			jQuery(document).ready(function () {
				$('#loader').show();
				$('#loader').fadeOut(2000);
			});
			</script>

		<script>

			jQuery(document).ready(function () {
				@if (!empty($funinit))
						@foreach ($funinit as $value)
							{{  $value }}
						@endforeach
				@endif
			});
		</script>

	</body>
	<!--end::Body-->
</html>
