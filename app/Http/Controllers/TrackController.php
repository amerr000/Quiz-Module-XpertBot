<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\user;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tracks=Track::all();
        return response()->json([
            'tracks'=>$tracks,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'name'=>'required|string|max:255|unique:tracks,name'
        ]);

        $track=Track::create($validated);
        return response()->json([
            'message'=>'track created successfully',
            'track'=>$track,
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $track=Track::find($id);
        if(!$track){
            return response()->json([
                'message'=>'track not found',
            ],404);
        }
        return response()->json([
            'track'=>$track,
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated=$request->validate([
            'name'=>'required|string|max:255|unique:tracks,name,'.$id,
        ]);

        $track=Track::findOrFail($id);
        if(!$track){
            return response()->json([
                'message'=>'track not found',
            ],404);
        }
        $track->update($validated);
        return response()->json([
            'message'=>'track updated successfully',
            'track'=>$track,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $track=Track::find($id);
        if(!$track){
            return response()->json([
                'message'=>'track not found',
            ],404);
        }
        $track->delete();
        return response()->json([
            'message'=>'track deleted successfully',
        ],200);
    }

    public function getStudentsEnrolledInTrack($id)
    {
        $track=Track::find($id);
        if(!$track)
        {
           return response()->json([
                'message'=>'track not found',
            ],404);
        }
        
        $students=$track->users()->get();
        return response()->json([
            'students'=>$students,
        ],200);

    }
}
