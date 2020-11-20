<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	public function index()
	{
		$users = User::All();
		return view('users.index', compact('users'));
	}

	public function create(){
		return view('users.create');
	}

    public function store(Request $request){
    	$user = new User();
    	$user->name = $request->name;
    	$user->lastname = $request->lastname;
    	$user->email = $request->email;
    	$user->address = $request->address;
    	$user->password = bcrypt($request->password);
    	$user->save();

    	return redirect()->route('users.show', $user->id);
    }

    public function show(User $user){
    	return view('users.show', compact('user'));
    }

    public function edit(User $user){
    	return view('users.edit', compact('user'));
    }

    function update(Request $request, User $user){
    	User::where('id', $user->id)->update([
    		'name' => $request->name,
    		'lastname' => $request->lastname
    	]);

    	return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user){
    	$user->delete();
    	return redirect()->route('users.index');
    }
}
