@extends('backend.pdf.layout.layout')

@section('section')
<div class="text-center"><span class="border-bottom">{{ $title }}</span></div>

<table id="countersheet-pdf-table">
    <tr>
        <th>#</th>
        <th>name</th>
        <th>email</th>
        <th>subject</th>
        <th>message</th>
    </tr>
    @php $i = 0; @endphp
    {{-- @forelse($contact_data_details as $value)
            @php $i++; @endphp
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->email }}</td>
                <td>{{ $value->subject }}</td>
                <td>{{ $value->message }}</td>
            </tr>
    @empty
        <tr>
            <td colspan="10" class="text-center">No Record Found</td>
        </tr>
    @endforelse --}}
</table>

@endsection

