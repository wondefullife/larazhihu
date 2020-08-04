<?php

namespace Tests\Feature\Answers;

use App\Answer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteAnswersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_delete_answers()
    {
        $answer = create(Answer::class);
        $this->withExceptionHandling()
            ->delete(route('answers.destroy', ['answer' => $answer]))
            ->assertRedirect('login');
    }

    /** @test */
    public function unauthorized_users_cannot_delete_answers()
    {
        $this->signIn();
        $answer = create(Answer::class);

        $this->withExceptionHandling()
            ->delete(route('answers.destroy', ['answer' => $answer]))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_answers()
    {
        $this->signIn();
        $answer = create(Answer::class, ['user_id' => auth()->id()]);

        $this->withExceptionHandling()
            ->delete(route('answers.destroy', ['answer' => $answer]))
            ->assertStatus(302);

        $this->assertDatabaseMissing('answers', ['id' => $answer->id]);
    }
}
