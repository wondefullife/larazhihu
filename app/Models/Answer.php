<?php

namespace App\Models;

use App\Models\Traits\VoteTrait;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use VoteTrait;

    protected $fillable = [
        'user_id', 'content', 'question_id'
    ];

    protected $appends = [
        'upVotesCount',
        'downVotesCount'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isBest()
    {
        return $this->id == $this->question->best_answer_id;
    }
}
