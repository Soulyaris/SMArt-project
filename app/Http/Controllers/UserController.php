<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\ImageModel as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    private function avatar_store($userId, $link) {
        $path = $link->store('avatars/'.$userId, 's3');
        Storage::disk('s3')->setVisibility($path, 'public');

        return $path;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'string|min:2|max:120',
        ]);
        $adminCheck = (!(Auth::user() && Auth::user()->isAdmin));

        $users = User::when($request, function ($query, $request) {
            if ($request->isMethod('post')):
                return $query->where('name', 'ILIKE', '%'.$request->username.'%');
            endif;
        })->when($adminCheck, function ($query, $adminCheck) {
            return $query->where('isActive', true);
        })->orderBy('name', 'asc')->paginate(15);

        return view('users.index', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request)
    {
        $adminCheck = (!(Auth::user() && Auth::user()->isAdmin));
        if ($user->isActive || !$adminCheck):
            $images = DB::table('images')->where('user', '=', $user->id)->when($adminCheck, function ($query, $adminCheck) {
                return $query->where('isActive', true);
            })->orderBy('id', 'desc')->paginate(15);

            return view('users.show', ['images' => $images, 'user' => $user]);
        else:
            return redirect()->route('users.index');
        endif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Gate::denies('update-user', $user)):
            return redirect()->route('users.show', ['user' => $user]);
        endif;

        return view('users.edit', ['user' => $user]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function deleteConfirmed(User $user) {
        if (Gate::denies('delete-user', $user)):
            return redirect()->route('users.show', ['user' => $user]);
        endif;

        $user->isActive = false;
        $user->save();
        return redirect()->route('users.index');
    }

    public function delete(User $user) {
        if (Gate::denies('delete-user', $user)):
            return redirect()->route('users.show', ['user' => $user]);
        endif;

        return view('users.delete', ['user' => $user]);
    }

    public function update(UserRequest $request) {

        $id = request()->route('user');
        $user = User::find($id);
        //return view('users.test', ['output' => $request->file('avatar')]);
        if ($request->get('name') != ""):
            $user->name = $request->get('name');
        endif;
        if ($request->get('email') != ""):
            $user->email = $request->get('email');
        endif;
        if ($request->get('password') != ""):
            $user->password = Hash::make($request->get('password'));
        endif;

        if ($request->file('avatar')):
            $link = $request->file('avatar');
            $user->avatar = $this->avatar_store($id, $link);
        endif;
        if (Auth::user()->isAdmin):
            if ($request->get('isActive') != null):
                $user->isActive = true;
            else:
                $user->isActive = false;
            endif;
            if ($request->get('isAdmin') != null):
                $user->isAdmin = true;
            else:
                $user->isAdmin = false;
            endif;
        endif;
        $user->save();
        return redirect()->route('users.show', ['user' => $user]);
    }
}
