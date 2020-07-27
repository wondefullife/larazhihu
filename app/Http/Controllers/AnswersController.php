<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function store(Question $question, Request $request)
    {
        $question->answers()->create([
            'user_id' => $request->input('user_id'),
            'content' => $request->input('content'),
        ]);

        return response()->json([], 201);
    }
}
