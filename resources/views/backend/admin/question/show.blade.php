@extends('frontend.layout.master')

@section('content')
	<div class="container">

{!! Form::model($question->id,['class'=>'','method'=>'put','url'=>route('question.setanswer',$question->id)]) !!}
	<div class="card">
	  <div class="card-body">
	    {!! $question->description !!}

	<div class="card"></div>

	@foreach($question->multiple_choice as $multiple_choice)
		<input type="radio" name="answer" value="{{ $multiple_choice->answer_choice }}">{!! $multiple_choice->answer_choice !!}. {!! $multiple_choice->answer_description !!} <br>
	@endforeach

	 <input type="submit" class="btn btn-primary" value="Save"></input>
	  </div>
	</div>
{!! Form::close() !!}
	

	</div>

@endsection

@push('scripts')

@endpush