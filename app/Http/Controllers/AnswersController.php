<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Http\Requests\AnswerRequest;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Question $question, AnswerRequest $request)
    {
        $question->answers()->create([
            'user_id' => Auth::user()->id,
            'content' => $request->input('content'),
        ]);

        return back()->with('flash', '回答发布成功!');
    }

    public function destroy(Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();
        return back()->with('flash', '删除成功！');
    }
}
