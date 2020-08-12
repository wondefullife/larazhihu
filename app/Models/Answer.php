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

    public function voteUp($user)
    {
        if ($this->votes('vote_up')->where(['user_id' => $user->id])->doesntExist()) {
            $this->votes('vote_up')->create(['user_id' => $user->id, 'type' => 'vote_up']);
        }
    }

    public function voteDown($user)
    {
        if ($this->votes('vote_down')->where(['user_id' => $user->id])->doesntExist()) {
            $this->votes('vote_down')->create(['user_id' => $user->id, 'type' => 'vote_down']);
        }
    }

    public function cancelVoteUp($user)
    {
        $this->votes('vote_up')->where(['user_id' => $user->id])->delete();
    }

    public function isVotedUp(User $user)
    {
        if (!$user) {
            return false;
        }
        return $this->votes('vote_up')->where('user_id', $user->id)->exists();
    }

    public function getUpVotesCountAttribute()
    {
        return $this->votes('vote_up')->count();
    }
}
