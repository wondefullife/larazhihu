<?php

namespace Tests\Feature;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BestAnswerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_mark_best_answer()
    {
        $question = create(Question::class);
        $answers = create(Answer::class, ['question_id' => $question->id], 2);
        $this->withExceptionHandling()
            ->post(route('best-answers.store', ['answer' => $answers[1]]), [$answers[1]])
            ->assertRedirect('/login');
    }

    /** @test */
    public function can_mark_one_answer_at_the_best()
    {
        $this->signIn();

        $question = create(Question::class, ['user_id' => auth()->id()]);
        $answers = create(Answer::class, ['question_id' => $question->id], 2);

        $this->assertFalse($answers[0]->isBest());
        $this->assertFalse($answers[1]->isBest());

        $this->postJson(route('best-answers.store', ['answer' => $answers[1]]), [$answers[1]]);
        $this->assertFalse($answers[0]->fresh()->isBest());
        $this->assertTrue($answers[1]->fresh()->isBest());
    }

    /** @test */
    public function only_the_question_creator_can_mark_best_answer()
    {
        // 生成作者
        // 生成属于作者的问题
        // 生成问题答案
        // 登录
        // 登陆者将答案标记为最佳答案失败
        $notCreator = create(User::class);
        $user = factory(User::class)->create();
        $question = create(Question::class, ['user_id' => $notCreator->id]);
        $answer = create(Answer::class, ['question_id' => $question->id]);
        $this->signIn();
        $this->withExceptionHandling();
        $this->postJson(route('best-answers.store', ['answer' => $answer]), [$answer])
            ->assertStatus(403);

        $this->assertFalse($answer->fresh()->isBest());
    }
}
