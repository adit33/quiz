<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultipleChoice extends Model
{
    protected $table='multiple_choice';
    protected $primaryKey='id';
    protected $fillable=['answer_choice','question_id','answer_description'];

    public function saveMultipleChoice($data){
    	foreach ($data['multiple_choice'] as $tmp) {
    		$multiple_choice=new MultipleChoice;
	    	$multiple_choice->answer_choice=$tmp['answer_choice'];
	    	$multiple_choice->answer_description=$tmp['answer_description'];
	    	$multiple_choice->question_id=$data['question_id'];
	    	$multiple_choice->save();
    	}
    }
}
