<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('password'), $user->password)) {
            $apikey = base64_encode(Str::random(40));
            while(User::where('api_key', $apikey)->first() != NULL){
                $apikey = base64_encode(Str::random(40));
            }
            User::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;
            return response()->json(['status' => 'success', 'api_key' => $apikey]);
        } else {
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->input('email'))->orWhere('username', $request->input('username'))->first();
        if(!empty($user))
            return response()->json(['status' => 'fail', 'message' => 'The email or username exists'], 409);
        
        if(User::Create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]))
            return response()->json(['status' => 'success']);
        return response()->json(['status' => 'fail'], 401);
    }
}