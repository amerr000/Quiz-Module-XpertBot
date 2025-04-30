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

        $added=$examQuestion->tracks()->syncWithoutDetaching([$track_id]);
        if (empty($added['attached'] && empty($added['detached']) && empty($added['updated']))) {
            return response()->json([
                'message' => 'This exam question is already assigned to the track.',
            ], 200);
        }

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
        $question=ExamQuestion::findOrFail($id);
        return response()->json($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $question=ExamQuestion::findOrFail($id);
        $validatedData=$request->validate([
            'question' => 'sometimes|string|max:255|unique:exam_questions,question,' . $id,
            'grade'=>'sometimes|numeric'
            
        ]);

        $question->update($validatedData);
        return response()->json([
            "message"=>"The record has been updated successfuly",
            "question"=>$question
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = ExamQuestion::findOrFail($id);
        $question->delete();
        return response()->json(["message"=>"question deleted successfuly"],204);
    }
#################################################################################I NEED TO ASK BOB ABOUT THIS ############################
    public function questionsAndAnswersOfTrack(Request $request,$id){
        $track=Track::findOrFail($id);
        $questions=$track->examQuestions()->get();
        if ($questions->isEmpty()) {
            return response()->json(['message' => 'No questions found for this track.'], 404);
        }
        $output=[];
        $output['track']=$track;
        
        $output['questions'] = [];

        foreach($questions as $question){
            
            $output['questions'][] = [
             
                'question' => $question->question, ###############SPECIFICALLY HERE
                
                'answers' => $question->answers##############AND HERE 
            ];
          
        }     
############################# my questions is if i removed the question attribute in the $question the answers will be redundant appear to times in the output
        return response()->json($output);

    }


    public function possibleAnswers(Request $request, $id){
        $question = ExamQuestion::findOrFail($id);

        $answers=$question->answers;
        if($answers->isEmpty()){
            return response()->json([
                "message"=>"There are no possible answers for this question yet!"
            ]);
        }
        return response()->json($question);

    }
}
