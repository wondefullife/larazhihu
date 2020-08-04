<?php

namespace Tests\Feature\Questions;

use App\Answer;
use App\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewQuestionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_questions()
    {
        // 假设路由 /questions 存在
        // 访问 /questions
        // 正常访问 code 200
        $this->withoutExceptionHandling();
        $response = $this->get('/questions');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_a_single_question()
    {
        $question = factory(Question::class)->state('published')->create();
        $response = $this->get('/questions/' . $question->id);
        $response->assertStatus(200)
            ->assertSee($question->title)
            ->assertSee($question->content);

    }

    /** @test */
    public function user_can_view_a_published_question()
    {
        $question = factory(Question::class)->state('published')->create();

        $response = $this->get('questions/' . $question->id)
            ->assertStatus(200)
            ->assertSee($question->title)
            ->assertSee($question->content);
    }

    /** @test */
    public function user_can_not_view_unpublished_question()
    {
        $question = factory(Question::class)->state('unpublished')->create();
        $response = $this->withExceptionHandling()
            ->get('/questions/'. $question->id)
            ->assertStatus(404);
    }

    /** @test */
    public function can_see_answers_when_view_a_published_question()
    {
        $question = factory(Question::class)
            ->state('published')
            ->create();

        $answer = factory(Answer::class)
            ->create(['question_id' => $question->id]);

        $otherAnswer = factory(Answer::class)->create();

        $ownerAnswers = factory(Answer::class, 40)->create(['question_id' => $question->id]);

        $response = $this->get('/questions/'. $question->id)
            ->assertStatus(200)
            ->assertSee($answer->content)
            ->assertDontSee($otherAnswer->content);

        $result = $response->data('answers')->toArray();
        $this->assertCount(20, $result['data']);
        $this->assertEquals(41, $result['total']);
    }
}
