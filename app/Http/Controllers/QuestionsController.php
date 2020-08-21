<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionsController extends Controller
{
    public function index()
    {
        //
    }

    public function show(Question $question)
    {
        $answers = $question->answers()->paginate(20);
        array_map(function (&$item) {
            return $this->appendVotedAttribute($item);
        }, $answers->items());

        return view('questions.show', [
            'question' => $question,
            'answers' => $question->answers()->paginate(20),
        ]);
    }
}
