@extends('backend.employee.layout.app')
@section('section')

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        @csrf
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">{{ $header['title'] }}</h3>
                </div>

                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                {{-- <section id="stopWatch">
                    <h5>Watch - Count Up Timer</h5>
                    <h6>Hour : Minutes : Seconds</h6>
                    <p id="timer"> 00:00:00 </p>
                    <button id="start" class="start" data-attr="start"> Start </button>
                    <button id="stop"> Stop </button>
                    <button id="pause"> Pause </button>
                    <button id="continue" hidden> Continue </button>
                    <p id="fulltime" class="fulltime"> </p>
                </section> --}}
                <!--end: Datatable-->
                <section id="stopWatch">
                <p id="timer">00:00:00</p>
                <button id="start">Start</button>
                <button id="stop">Stop</button>
                <button id="pause">Pause</button>
                {{-- <button id="continue" hidden>Continue</button> --}}
                <button id="continue" style="display: none">Continue</button>
                </section>

            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
@endsection


