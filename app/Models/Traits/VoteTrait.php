<?php

namespace App\Models\Traits;

use App\Models\Vote;

trait VoteTrait
{
    public function votes($type)
    {
        return $this->morphMany(Vote::class, 'voted')->whereType($type);
    }

    protected function vote($user, $type)
    {
        if ($this->votes($type)->where(['user_id' => $user->id])->doesntExist()) {
            $this->votes($type)->create(['user_id' => $user->id, 'type' => $type]);
        }
    }

    public function voteUp($user)
    {
        $this->vote($user, 'vote_up');
    }

    public function voteDown($user)
    {
        $this->vote($user, 'vote_down');
    }

    protected function cancelVote($user, $type)
    {
        $this->votes($type)->where(['user_id' => $user->id])->delete();
    }

    public function cancelVoteUp($user)
    {
        $this->cancelVote($user, 'vote_up');
    }

    public function cancelVoteDown($user)
    {
        $this->cancelVote($user, 'vote_down');
    }

    protected function isVoted($user, $type)
    {
        if (!$user) {
            return false;
        }
        return $this->votes($type)->where('user_id', $user->id)->exists();
    }

    public function isVotedUp($user)
    {
        return $this->isVoted($user, 'vote_up');
    }

    public function isVotedDown($user)
    {
        return $this->isVoted($user, 'vote_down');
    }

    public function getUpVotesCountAttribute()
    {
        return $this->votes('vote_up')->count();
    }

    public function getDownVotesCountAttribute()
    {
        return $this->votes('vote_down')->count();
    }
}
