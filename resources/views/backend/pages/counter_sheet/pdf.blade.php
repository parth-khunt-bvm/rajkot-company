@extends('backend.pdf.layout.layout')

@section('section')
<div class="text-center"><span class="border-bottom">{{ $title }}</span></div>

<table id="countersheet-pdf-table">
    <tr>
        <th>#</th>
        <th>Employee</th>
        <th>Department</th>
        <th>wd</th>
        <th>pd</th>
        <th>ab</th>
        <th>hl</th>
        <th>sl</th>
        <th>ot</th>
        <th>total</th>
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
                <td>{{ $value->total }}</td>
            </tr>
    @empty
        <tr>
            <td colspan="10" class="text-center">No Record Found</td>
        </tr>
    @endforelse
</table>

@endsection

