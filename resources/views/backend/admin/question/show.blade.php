@extends('frontend.layout.master')

@section('content')
	<div class="container">

	<div class="card">
	  <div class="card-body">
	    {!! $question->description !!}

	<div class="card"></div>

	@foreach($question->multiple_choice as $multiple_choice)
		<input type="radio" name="answer">{!! $multiple_choice->answer_choice !!}. {!! $multiple_choice->answer_description !!} <br>
	@endforeach

	 <a href="#" class="btn btn-primary">Go somewhere</a>
	  </div>
	</div>

	</div>

@endsection

@push('scripts')

@endpush