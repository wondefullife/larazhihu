<?php

namespace App\Models;

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

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function votes($type)
    {
        return $this->morphMany(Vote::class, 'voted')->whereType($type);
    }

    public function isBest()
    {
        return $this->id == $this->question->best_answer_id;
    }

    public function voteUp(User $user)
    {
        $this->votes('vote_type')->create(['user_id' => $user->id]);
    }
}
