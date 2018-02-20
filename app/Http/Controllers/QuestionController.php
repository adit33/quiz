<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;

class QuestionController extends Controller
{
    public function create(){
    	return view('backend.admin.question.create')
    	->withTitle('Create Question');
    }

    public function store(Request $request){
    	Question::create($request->all());
    }
}
