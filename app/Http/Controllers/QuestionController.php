<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;

use App\Models\MultipleChoice;

use App\Models\Answer;

use App\DataTables\QuestionDataTable;

use App\Http\Requests\QuestionsRequest;

class QuestionController extends Controller
{
	public function __construct(Question $question){
		$this->question = $question;
	}

    public function index(QuestionDataTable $dataTable){
        $title='index';
        return $dataTable->render('backend.admin.question.index',compact('title'));
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
    	$question=Question::with('multiple_choice','answer')->find($id);
    	return view('backend.admin.question.show',compact('question'));
        
    }

    public function setAnswer($id,Request $request){
       $answer = new Answer;
       $data['question_id']=$id;
       $data['answer']=$request->input('answer');

       $answer->saveAnswer($data); 
    }

    public function getQuestion(){
    	$question=Question::with('multiple_choice','answer')->get();
    	return $question;
    }

    public function checkAnswer($question_id){
        $question=Question::with('multiple_choice','answer')->find($question_id);
        
    }

}
