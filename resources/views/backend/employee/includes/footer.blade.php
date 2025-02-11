<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "var(--theme-color)", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };
</script>
<!--end::Global Config-->

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{  asset('backend/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{  asset('backend/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{  asset('backend/js/scripts.bundle.js') }}"></script>
<!--end::Global Theme Bundle-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{  asset('backend/js/pages/widgets.js') }}"></script>
<!--end::Page Scripts-->
<script src="{{  asset('backend/js/script.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/customjs/common.js') }}" type="text/javascript"></script>
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
    $('#loader').fadeOut(1000);
    $('.select2').select2();
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
