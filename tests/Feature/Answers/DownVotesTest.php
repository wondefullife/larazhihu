<?php

namespace Tests\Feature\Answers;

use App\Models\Answer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DownVotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_not_down_vote()
    {
        $this->withExceptionHandling()
            ->post("/answers/1/down-votes")
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_down_vote()
    {
        $this->signIn();
        $answer = create(Answer::class);
        $this->post("/answers/{$answer->id}/down-votes")
            ->assertStatus(201);

        $this->assertCount(1, $answer->refresh()->votes('vote_down')->get());
    }

    /** @test */
    public function an_authenticated_user_can_cancel_down_vote()
    {
        $this->signIn();

        $answer = create(Answer::class);
        $this->post("/answers/{$answer->id}/down-votes");
        $this->assertCount(1, $answer->refresh()->votes('vote_down')->get());

        $this->delete("/answers/{$answer->id}/down-votes");
        $this->assertCount(0, $answer->refresh()->votes('vote_down')->get());
    }

    /** @test */
    public function can_vote_down_only_once()
    {
        $this->signIn();
        $answer = create(Answer::class);

        try {
            $this->post("/answers/{$answer->id}/down-votes");
            $this->post("/answers/{$answer->id}/down-votes");
        } catch (\Exception $e) {
            $this->fail("Can't vote down twice");
        }
        $this->assertCount(1, $answer->refresh()->votes('vote_down')->get());
    }
}
