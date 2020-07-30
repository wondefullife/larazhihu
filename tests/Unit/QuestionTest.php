<?php

namespace Tests\Unit;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_question_has_many_answers()
    {
        $question = factory(Question::class)->create();
        create(Answer::class, ['question_id' => $question->id]);

        $this->assertInstanceOf(HasMany::class, $question->answers());
    }

    /** @test */
    public function questions_published_scope()
    {
        $publishedQuestion1 = factory(Question::class)->state('published')->create();
        $publishedQuestion2 = factory(Question::class)->state('published')->create();
        $unpublishedQuestion = factory(Question::class)->state('unpublished')->create();

        $publishedQuestions = Question::published()->get();

        $this->assertTrue($publishedQuestions->contains($publishedQuestion1));
        $this->assertTrue($publishedQuestions->contains($publishedQuestion2));
        $this->assertFalse($publishedQuestions->contains($unpublishedQuestion));
    }

    /** @test */
    public function can_mark_an_answer_as_best()
    {
        // 创建问题
        // 创建问题答案
        // 将答案标记为最佳答案
        $question = create(Question::class);
        $answer = create(Answer::class, ['question_id' => $question->id]);
        $question->markAsBestAnswer($answer);

        $this->assertEquals($question->best_answer_id, $answer->id);
    }
}
