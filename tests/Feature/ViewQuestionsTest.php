<?php

namespace Tests\Feature;

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
        $question = factory(Question::class)->create();
        $response = $this->get('/questions/' . $question->id);
        $response->assertStatus(200)
            ->assertSee($question->title)
            ->assertSee($question->content);

    }
}
