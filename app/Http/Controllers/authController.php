<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class authController extends Controller
{
    //
    public function register(Request $request){
        $request->validate(
            [
                'full_name'=>'required|string|max:255',
                'email'=>'required|string|email|max:255|unique:students',
                'password'=>'required|string|min:6|confirmed',
            ]

            );
            $student=Student::create(
                [
                    'full_name'=>$request->full_name,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                ]
                );

                return response()->json([
                    'message'=>'Student created successfully',
                    'student'=>$student,
                ],201);


    }


    public function login(Request $request){
        $request->validate(
            [
                'email'=>'required|string|email|max:255',
                'password'=>'required|string',
            ]
        );
        $student=Student::where('email',$request->email)->first();
        if(!$student || !password_verify($request->password,$student->password)){
            return response()->json([
                'message'=>'Invalid credentials',
            ],401);
        }
        $token=$student->createToken('token')->plainTextToken;
        return response()->json([
            'message'=>'Login successful',
            'token'=>$token,
        ],200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message'=>'Logout successful',
        ],200);
    }
}
