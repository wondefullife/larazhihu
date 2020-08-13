<?php

namespace Tests\Feature;

trait VoteDownContractTest
{
    /** @test */
    public function guest_can_not_down_vote()
    {
        $this->withExceptionHandling()
            ->post($this->getVoteDownUri())
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_down_vote()
    {
        $this->signIn();
        $model = create($this->getModel());
        $this->post($this->getVoteDownUri($model))
            ->assertStatus(201);

        $this->assertCount(1, $this->downVotes($model));
    }

    /** @test */
    public function an_authenticated_user_can_cancel_down_vote()
    {
        $this->signIn();

        $model = create($this->getModel());
        $this->post($this->getVoteDownUri($model));
        $this->assertCount(1, $this->downVotes($model));

        $this->delete($this->getVoteDownUri($model));
        $this->assertCount(0, $this->downVotes($model));
    }

    /** @test */
    public function can_vote_down_only_once()
    {
        $this->signIn();
        $model = create($this->getModel());

        try {
            $this->post($this->getVoteDownUri($model));
            $this->post($this->getVoteDownUri($model));
        } catch (\Exception $e) {
            $this->fail("Can't vote down twice");
        }
        $this->assertCount(1, $this->downVotes($model));
    }

    /** @test */
    public function can_known_it_is_vote_down()
    {
        $this->signIn();
        $model = create($this->getModel());
        $this->post($this->getVoteDownUri($model));

        // 这里注意要 refresh 重新读取数据一下
        $this->assertTrue($model->refresh()->isVotedDown(auth()->user()));
    }

    /** @test */
    public function can_known_votes_down_count()
    {
        $model = create($this->getModel());
        $this->signIn();
        $this->post($this->getVoteDownUri($model));

        $this->signIn();
        $this->post($this->getVoteDownUri($model));

        $this->assertEquals(2, $model->downVotesCount);
    }

    abstract protected function getVoteDownUri($model = null);

    abstract protected function downVotes($model);

    abstract protected function getModel();
}

