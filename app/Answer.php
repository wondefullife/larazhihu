<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'user_id', 'content', 'question_id'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function isBest()
    {
        return $this->id == $this->question->best_answer_id;
    }
}
