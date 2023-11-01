<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthorsController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('users', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Log::info("User with ID $user->id, Name: $user->name, Email: $user->email is being deleted by " . auth()->user()->name);
        $user->delete();

        return redirect()->back()->with('status', 'User deleted successfully!');
    }

    public function userStatus($id, $action)
    {
        $user = User::findOrFail($id);
        $validActions = ['block', 'unblock'];

        if (!in_array($action, $validActions)) {
            return redirect()->back()->with('error', 'Invalid action.');
        }
        $user->status = $action === 'block' ? false : true;
        $user->save();
        Log::info("User with ID $user->id, Name: $user->name, Email: $user->email is " . ($action === 'block' ? 'blocked' : 'unblocked') . " by " . auth()->user()->name);

        return redirect()->back()->with('status', "User " . ($action === 'block' ? 'blocked' : 'unblocked') . " successfully.");
    }
}
