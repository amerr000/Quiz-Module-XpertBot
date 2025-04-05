<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamQuestion;
use App\Models\Answer;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $question=ExamQuestion::findOrFail($id);
        $answers=$question->answers;
        if(!$answers->isEmpty())
        return response()->json($answers);
        return response()->json([
            "message"=>"This question has no answers yet"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$question_id)
    {
        $examQuestion=ExamQuestion::findOrFail($question_id);

        $validatedData=$request->validate([
            'answer'=>'required|string|unique:answers,answer',
            "is_correct"=>'required|boolean'
        ]);
        
        $validatedData['exam_question_id'] = $question_id;
        $answer=Answer::create($validatedData);
        return response()->json([
            "message"=>"answer created successfuly",
            "Answer"=>$answer
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
