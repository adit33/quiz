<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;

use App\Models\MultipleChoice;

use App\Http\Requests\QuestionsRequest;

class QuestionController extends Controller
{
	public function __construct(Question $question){
		$this->question = $question;
	}

    public function create(){
    	return view('backend.admin.question.create')
    	->withTitle('Create Question');
    }

    public function store(QuestionsRequest $request){
    	$question=new Question;
    	$multiple_choice=new MultipleChoice;
    	$this->question->saveQuestion($request,$question);

    	// return dd($request->all());
    }

    public function show($id){
    	$question=Question::with('multiple_choice')->find($id);
    	return view('backend.admin.question.show',compact('question'));
    }

    public function getQuestion(){
    	$question=Question::with('multiple_choice')->find(25);

    	return $question;
    }

}
