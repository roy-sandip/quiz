<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function quiz()
    {
        $question = Question::inRandomOrder()
                            //->where('type', 'boolean')
                            ->first();

        return view('admin.quiz.quiz', compact('question'));
    }

    public function checkAnswer(Request $request)
    {
        $request->validate([
            'id'       => ['required', 'integer', 'exists:App\Models\Question'],
            'answer'    => ['required', 'string', 'max:10'],
        ]);
        $question = Question::findOrFail($request->input('id'));
        $result = $question->isCorrect($request->input('answer'));
        $newQuestion = Question::select(['id', 'question', 'options', 'type'])
                                ->inRandomOrder()
                                ->first()->shuffleOptions();

        return response()->json([
                'result'    => $result,
                'question'  => $question->only(['id','question', 'options', 'answer', 'type']),
                'newQuestion' => $newQuestion

        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
