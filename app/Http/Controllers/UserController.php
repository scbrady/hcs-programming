<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        return view('user.settings')->with('user', Auth::user());
    }

    /**
     * Update logged in user
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateMe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::id()
        ]);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $request->session()->flash('alert-success', 'Successfully updated your information');
        return redirect()->route('settings');
    }

    /**
     * Change the password of the logged in user
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $messages = ['old_password' => 'The old password is incorrect.'];
        $validator = Validator::make($request->all(), [
            'current-password' => 'required|old_password',
            'password' => 'required|min:6|confirmed'
        ], $messages);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = Auth::user();
        $user->password = $request->password;
        $user->save();

        $request->session()->flash('alert-success', 'Your password has been changed.');
        return redirect()->route('settings');
    }
}
