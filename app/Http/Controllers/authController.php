<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Events\EventExample;
use Cookie;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use SebastianBergmann\CliParser\Exception;
use Tymon\JWTAuth\src\Exception\JWTException;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Support\Facades\DB;


class authController extends Controller
{
    public function register(Request $request){
        $user=User::where('email',$request['email'])->first();

        if ($user){
            $response['status']=0;
            $response['message']='Duplikat email-a';
            $response['code']=409;
        }



        else{

            $user = new User();
            $user->email =$request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->name= $request->input('name');
            $user->role = 1;
            $user->save();
            $response['status']=1;
            $response['message']='Cestitamo uspjesno ste se registrovali !';
            $response['code']=200;


        }
        return $response;
    }





    public function  login(Request  $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        try{

            $user =User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'username' => ['The provided credentials are incorrect.'],
                ]);
            }
            //send token to the register user
            $token = $user->createToken('Laravel-Sanctum')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function user(){
        return Auth::User();
    }


    public function edit(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);

        if($user->role == 1)
        {
            $user->role = 2;
        }else if($user->role == 2)
        {
            $user->role = 1;
        }
        $user->save();
        return User::all();
    }

    public function show()
    {
        return user::all();
    }
}
