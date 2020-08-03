<?php

namespace Tests\Feature\Answers;

use App\Question;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostAnswersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_post_an_answer_to_a_published_question()
    {
        $question = factory(Question::class)->state('published')->create();
        $user = create(User::class);
        $this->actingAs($user);
        $response = $this->post("questions/{$question->id}/answers", [
            'content' => 'First answer',
        ]);
        $response->assertStatus(302);

        $answer = $question->answers()->where('user_id', $user->id)->first();
        $this->assertNotNull($answer);
        $this->assertEquals(1, $question->answers()->count());
    }

    /** @test */
    public function user_can_not_post_an_answer_to_a_unpublished_question()
    {
        $unpublishedQuestion = factory(Question::class)->state('unpublished')->create();
        $user = create(User::class);
        $this->actingAs($user);

        $response = $this->withExceptionHandling()
            ->post("questions/{$unpublishedQuestion->id}/answers", [
                'content' => 'First answer',
            ])->assertStatus(404);

        $this->assertDatabaseMissing('answers', ['question_id' => $unpublishedQuestion->id]);
        $this->assertEquals(0, $unpublishedQuestion->answers()->count());
    }

    /** @test */
    public function content_is_required_when_post_answer()
    {
        $question = factory(Question::class)->state('published')->create();
        $user = create(User::class);
        $this->actingAs($user);
        $response = $this->withExceptionHandling()
            ->post("questions/{$question->id}/answers", [
                'content' => null,
            ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('content');
    }

    /** @test */
    public function guest_can_not_post_an_answer()
    {
        $this->expectException(AuthenticationException::class);
        $publishedQuestion = factory(Question::class)->state('published')->create();

        $this->post("questions/{$publishedQuestion->id}/answers", [
                'content' => 'First answer',
        ]);
    }
}
