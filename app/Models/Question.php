<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MultipleChoice;


class Question extends Model
{
    protected $table='questions';
    protected $primaryKey='id';
    protected $fillable=['description','question_type_id'];

    public function saveQuestion($request,$question){
		$question->description      = $request->input('description');
		$question->question_type_id = $request->input('question_type_id');
		$question->save();

		$multiple_choice=new MultipleChoice;
		$multiple_choice_data['multiple_choice']=$request->input('multiple_choice');
		$multiple_choice_data['question_id']=$question->id;
		$multiple_choice->saveMultipleChoice($multiple_choice_data);

		return $multiple_choice_data;
    }

    public function multiple_choice(){
    	return $this->hasMany(MultipleChoice::class);
    }

}
