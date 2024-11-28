<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => [
			    'required',
			    'digits:10', // Ensures the number is exactly 10 digits
			    'numeric',   // Ensures only numbers
			    'unique:users,phone', // Ensures the phone number is unique in the users table
			], // Indian phone number validation
            'role_id' => 'required|exists:roles,id',
            'description' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        //$validated = $request->validate([
         //   'name' => 'nullable',
         //   'email' => 'nullable',
         //   'phone' =>'nullable',
         //   'role_id' => 'nullable',
         //   'description' => 'nullable',
          //  'profile_image' => 'nullable',
      //  ]);

       	

        $user = new User();
		$user->name = $validated['name'];
		$user->email = $validated['email'];
		$user->phone = $validated['phone'];
		$user->role_id = $validated['role_id'];
		$user->description = $validated['description'] ?? null;
		//$user->profile_image = $validated['profile_image'] ?? null;
		$user->save();

		$image = $request->file('profile_image');
		if ($request->hasFile('profile_image')) {
		    // Define the destination path
		    $destinationPath = 'images/users/'.$user->id; // Relative to public directory
		    $imageName = time() . '.' . $image->getClientOriginalExtension(); // Generate unique filename
		    // Move the file
		    if ($image->move(public_path($destinationPath), $imageName)) {
		        // Save the complete path
		        $validated['profile_image'] = $destinationPath . '/' . $imageName;
		    }
		}
		$user->profile_image = $validated['profile_image'] ?? null;
		$user->save();



        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'data' => $user->load('role'),
        ]);
    }

    public function index()
    {
        $users = User::with('role')->get();

        return response()->json($users);
    }
}

