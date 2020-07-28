<?php

namespace Tests\Feature;

use App\Question;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostAnswersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_post_an_answer_to_a_published_question()
    {
        $question = factory(Question::class)->state('published')->create();
        $user = factory(User::class)->create();

        $response = $this->post("questions/{$question->id}/answers", [
            'user_id' => $user->id,
            'content' => 'First answer',
        ]);

        $response->assertStatus(201);

        $answer = $question->answers()->where('user_id', $user->id)->first();
        $this->assertNotNull($answer);
        $this->assertEquals(1, $question->answers()->count());
    }

    /** @test */
    public function user_can_not_post_an_answer_to_a_unpublished_question()
    {
        $unpublishedQuestion = factory(Question::class)->state('unpublished')->create();
        $user = factory(User::class)->create();

        $response = $this->withExceptionHandling()
            ->post("questions/{$unpublishedQuestion->id}/answers", [
            'user_id' => $user->id,
            'content' => 'First answer',
            ])->assertStatus(404);

        $this->assertDatabaseMissing('answers', ['question_id' => $unpublishedQuestion->id]);
        $this->assertEquals(0, $unpublishedQuestion->answers()->count());
    }
}
