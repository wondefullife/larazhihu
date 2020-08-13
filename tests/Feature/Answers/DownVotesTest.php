<?php

namespace Tests\Feature\Answers;

use App\Models\Answer;
use Tests\Feature\VoteDownContractTest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DownVotesTest extends TestCase
{
    use RefreshDatabase;
    use VoteDownContractTest;

    protected function getVoteDownUri($model = null)
    {
        return $model ? "/answers/{$model->id}/down-votes" :"/answers/1/down-votes" ;
    }

    protected function downVotes($model)
    {
        return $model->refresh()->votes('vote_down')->get();
    }

    protected function getModel()
    {
        return Answer::class;
    }
}
