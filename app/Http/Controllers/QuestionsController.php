<?php

namespace App\Http\Controllers;

use App\Question;

class QuestionsController extends Controller
{
    public function index()
    {
        //
    }

    public function show(Question $question)
    {
        return view('questions.show', [
            'question' => $question,
            'answers' => $question->answers()->paginate(20),
        ]);
    }
}
