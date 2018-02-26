@extends('backend.layout.master')


@section('content')
	{!! $dataTable->table() !!}
@endsection

@push('scripts')
<script type="text/javascript" src="http://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	{!! $dataTable->scripts() !!}
@endpush