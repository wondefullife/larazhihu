<?php

namespace Tests\Unit;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_knows_if_it_is_the_best()
    {
        /** @var Answer $answer */
        $answer = create(Answer::class);
        $this->assertFalse($answer->isBest());
        $answer->question->update(['best_answer_id' => $answer->id]);
        $this->assertTrue($answer->isBest());
    }

    /** @test */
    public function an_answer_belongs_to_a_question()
    {
        /** @var Answer $answer */
        $answer = create(Answer::class);
        $this->assertInstanceOf(BelongsTo::class, $answer->question());
    }

    /** @test */
    public function an_answer_belongs_to_owner()
    {
        $answer = create(Answer::class);
        $this->assertInstanceOf(BelongsTo::class, $answer->owner());
        $this->assertInstanceOf(User::class, $answer->owner);
    }
}
