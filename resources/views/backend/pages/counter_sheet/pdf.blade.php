@extends('backend.pdf.layout.layout')

@section('section')


<div class="text-center"><span class="border-bottom">{{ $title }}</span></div>
<br>
<div id="details" class="clearfix">
    <div id="client">
      <span class="name">Branch : {{ $branch }}</span><br>
      <span class="name">Technology : {{ $technology }}</span>
    </div>
    <div id="invoice">
      <span class="name">Month/Year : {{ $month }} - {{ $year }}</span><br>
      <span>Date: {{ date_formate(date('Y-m-d'))}}</span>
    </div>
</div>

<table id="countersheet-pdf-table">
    <tr>
        <th>#</th>
        <th>Emp.</th>
        <th>Dept.</th>
        <th>W.D.</th>
        <th>P.D.</th>
        <th>A.B.</th>
        <th>H.L.</th>
        <th>S.L.</th>
        <th>O.T.</th>
        <th>N.O.W</th>
        <th>TP</th>
    </tr>
    @php $i = 0; @endphp
    @forelse($counterSheet as $value)
            @php $i++; @endphp
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $value->full_name }}</td>
                <td>{{ $value->technology_name }}</td>
                <td>{{ $value->totalDays }}</td>
                <td>{{ $value->presentCount }}</td>
                <td>{{ $value->absentCount }}</td>
                <td>{{ $value->halfDayCount }}</td>
                <td>{{ $value->sortLeaveCount }}</td>
                <td>{{ $value->overTime }}</td>
                <td>{{ $value->totalWorkingDays }}</td>
                <td>
                    {{ $value->totalWorkingDays < 15 ? $value->totalWorkingDays : ($value->totalWorkingDays + 1 > $value->totalDays ? $value->totalDays : $value->totalWorkingDays . "+1=" . ($value->totalWorkingDays + 1)) }}
                </td>
            </tr>
    @empty
        <tr>
            <td colspan="10" class="text-center">No Record Found</td>
        </tr>
    @endforelse
</table>

@endsection

