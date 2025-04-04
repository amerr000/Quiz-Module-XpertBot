<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamQuestion;
use App\Models\Track;

class QuestionController extends Controller
{
    
    public function QuestionsOfTrack(Request $request,$track_id)
    {
       
        $track=Track::findOrFail($track_id);
        $questions=$track->examQuestions;
        if ($questions->isEmpty()) {
            return response()->json(['message' => 'No questions found for this track.'], 404); // Return 404 if no questions exist
        }
        return response()->json($questions,200);

    }

   
    public function store(Request $request)
    {
       $validatedData = $request->validate([
        'question'=>'required|string|unique:exam_questions,question',
        'grade'=>'required|numeric|min:1|max:100',
        ]);

        $question = ExamQuestion::create($validatedData);
        return response()->json([
            "message"=>"Question created successfuly",
            "question"=>$question
        
        ],201);
    }

    public function assignQuestionToTrack(Request $request){
        $request->validate([
            'track_id'=>'required|numeric|exists:tracks,id',
            'exam_question_id'=>'required|numeric|exists:exam_questions,id'
        ]);

        $track_id=$request->track_id;
        $exam_question_id=$request->exam_question_id;

        $examQuestion=ExamQuestion::findOrFail($exam_question_id);
        $examQuestion->tracks()->attach($track_id);

        return response()->json([
            'message'=>'Assignment completed successfully',
            'track_id'=>$track_id,
            'exam_question_id'=>$exam_question_id
        ],201);
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
