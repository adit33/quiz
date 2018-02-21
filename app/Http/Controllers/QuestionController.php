<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;

use App\Http\Requests\QuestionsRequest;

class QuestionController extends Controller
{
    public function create(){
    	return view('backend.admin.question.create')
    	->withTitle('Create Question');
    }

    public function store(QuestionsRequest $request){
    	// Question::create($request->all());
    	return dd($request->all());
    }
}
