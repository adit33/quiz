<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	protected $table='answers';
	protected $fillable=['question_id','answer'];

    public function saveAnswer($data){
		Answer::updateOrCreate(['question_id'=>$data['question_id']],['answer'=>$data['answer']]);
    }
}
