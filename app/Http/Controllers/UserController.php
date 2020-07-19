<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post') && $request->username != ""):
            $username = $request->username;
            $users = User::where('name', 'like', '%'.$username.'%')->paginate(15);
            //return view('users.test', ['output' => $request->username]);
        else:
            $users = User::paginate(15);
        endif;
        return view('users.index', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Gate::allows('update-user', $user)):
            return view('users.edit', ['user' => $user]);
        else:
            return redirect()->route('users.show', ['user' => $user]);
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function deleteConfirmed(User $user) {
        if (Gate::allows('delete-user', $user)):
            $user->update(array('isActive' => false));
            return redirect()->route('users.index');
        else:
            return redirect()->route('users.show', ['user' => $user]);
        endif;
    }

    public function delete(User $user) {
        if (Gate::allows('delete-user', $user)):
            return view('users.delete', ['user' => $user]);
        else:
            return redirect()->route('users.show', ['user' => $user]);
        endif;
    }
}
