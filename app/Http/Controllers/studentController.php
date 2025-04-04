<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
   

     public function trackRegister(Request $request){
        
        $request->validate([
            'track_id'=>'required|exists:tracks,id',
        ]);

        $user=$request->user();
        $track=Track::findorFail($request->track_id);
        //check if the user is already registered in the track
        if($user->tracks()->where('track_id',$track->id)->exists()){
            return response()->json([
                'message'=>'user already registered in this track',
               
            ]);
        }
        $user->tracks()->attach($track->id);
        return response()->json([
            'message'=>'user registered in track successfully',
            'user_id'=>$user->id,
            'track_id'=>$track->id,
        ]);





    }
    public function index()
    {
        $students=User::where('role', 'student')->get();
        return response()->json([
            'students'=>$students,
        ],200);
    }

    
   

    public function show(string $id)
    {
        $student=User::where('id', $id)->where('role', 'student')->first();
        if(!$student){
            return response()->json([
                'message'=>'student not found',
            ],404);
        }
        return response()->json([
            'student'=>$student,
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student=User::where('id', $id)->where('role', 'student')->first();
        if(!$student){
            return response()->json([
                'message'=>'student not found',
            ],404);
        }

        $request->validate([
            'name'=>'sometimes|string|max:255',
            'email'=>'sometimes|string|email|max:255|unique:users,email,'.$student->id,// this means to execlude the current email from being unique
            'password'=>'sometimes|string|min:8|confirmed',
        ]);
        $student->update($request->all());
        return response()->json([
            'message'=>'student updated successfully',
            'student'=>$student,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student=User::where('id', $id)->where('role', 'student')->first();
        if(!$student){
            return response()->json([
                'message'=>'student not found',
            ],404);
        }
        $student->delete();
        return response()->json([
            'message'=>'student deleted successfully',
        ],200);
    }

    public function getAllRegisteredTracks(){
        $user=Auth::user();
        $tracks=$user->tracks;

        $transformedTracks=$tracks->map(function($singleTrack){
            $pivot=$singleTrack->pivot;
            return [
                "id"=>$singleTrack->id,
                "name"=>$singleTrack->name,
                "status"=>$pivot->status,
                "score"=>$pivot->score

            ];
        });
        if($tracks->isEmpty()){
            return response()->json([
                'message'=>'user not registered in any track',
            ],404);
        }
        return response()->json([
            'tracks'=>$transformedTracks,
        ],200);
    }
}
