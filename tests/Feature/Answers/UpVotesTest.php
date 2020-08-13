<?php

namespace Tests\Feature\Answers;

use App\Models\Answer;
use Tests\Feature\VoteUpContractTest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpVotesTest extends TestCase
{
    use RefreshDatabase;
    use VoteUpContractTest;

    protected function getVoteUpUri($model = null)
    {
        return $model ? "/answers/{$model->id}/up-votes" : "/answers/1/up-votes";
    }

    protected function upVotes($model)
    {
        return $model->refresh()->votes('vote_up')->get();
    }

    protected function getModel()
    {
        return Answer::class;
    }
}
