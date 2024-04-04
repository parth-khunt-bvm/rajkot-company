@php

    $currentRoute = Route::current()->getName();

@endphp

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-baseline flex-wrap mr-5">
            <!--begin::Page Title-->
            {{-- <h5 class="text-dark font-weight-bold my-1 mr-5">{{$header['title']}}</h5> --}}
            <!--end::Page Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">

                @php
                    $count = count($header['breadcrumb']);
                    $temp = 1;
                @endphp
                @foreach ($header['breadcrumb'] as $key => $value)
                    @php
                        $value = empty($value) ? 'javascript:;' : $value;
                    @endphp

                    @if ($temp != $count)
                        <li class="breadcrumb-item">
                            <a href="{{ $value }}" class="" style="color: #4e5161;">
                                @if ($temp == 1)
                                    <i class="fa fa-home"
                                        style="color: #4e5161;"></i>&nbsp;&nbsp;&nbsp;{{ $key }}
                                @else
                                    {{ $key }}
                                @endif
                            </a>
                        </li>
                    @else
                        <li class="breadcrumb-item ">{{ $key }}</li>
                    @endif

                    @php
                        $temp = $temp + 1;
                    @endphp
                @endforeach

            </ul>
        </div>
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Actions-->
            <p id="fulltime" class="fulltime"> </p>
            <p id="timer">00:00:00</p>
            <button id="toggle">
                <div id="squareInside"></div>
            </button>

            <!--end::Actions-->
        </div>
        <!--end::Toolbar-->

        <!--end::Info-->

    </div>
</div>
<!--end::Subheader-->
