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
}
