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
        $answer=Answer::findOrFail($id);
       return response()->json([
            "answer"=>$answer
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $answer=Answer::findOrFail($id);
        $validatedData=$request->validate([
            'answer'=>'sometimes|string|max:255|unique:answers,answer,' . $id,
            'exam_question_id'=>'sometimes|numeric|exists:exam_questions,id',
            'is_correct'=>'sometimes|boolean'
        ]);

        $answer->update($validatedData);
        return response()->json([
            'message'=>"answer updated successfuly"
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return response()->json([
            "message"=>"answer deleted successfuly"
        ],200);
    }

    public function getQuestionOfAnswer($id){
        $answer=Answer::findOrFail($id);
        $question=$answer->examQuestion;
        return response()->json($question);

    }
}
