<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{


    public function index()
    {

        $user = Auth::user();


        return view(
            'profile.index',
            compact('user')
        );

    }





    public function update(Request $request)
    {


        $request->validate([

            'name'=>'required',
            'email'=>'required|email'

        ]);



        $user = Auth::user();



        $user->update([

            'name'=>$request->name,

            'email'=>$request->email

        ]);



        return back();

    }





    public function password(Request $request)
    {


        $request->validate([

            'current_password'=>'required',

            'password'=>'required|min-8|confirmed'


        ]);



        $user = Auth::user();



        if(!Hash::check(
            $request->current_password,
            $user->password
        )){


            return back()->withErrors([

                'current_password'=>'Current password incorrect'

            ]);


        }



        $user->update([


            'password'=>Hash::make(
                $request->password
            )


        ]);



        return back();


    }


}