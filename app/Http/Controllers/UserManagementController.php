<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth'); 
        // $this->middleware(function ($request, $next) {
        //     if (auth()->user()->role !== 'admin') {
        //         abort(403, 'Unauthorized action.');
        //     }
        //     return $next($request);
        // });
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('dashboard.user-management', compact('users'));
    }

    public function show(User $user)
    {
        return view('dashboard.user-details', compact('user'));
    }

    public function ban(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot ban your own account!');
        }

        $user->ban();

        return back()->with('success', 'User banned successfully!');
    }

    public function unban(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot unban your own account!');
        }

        $user->unban();

        return back()->with('success', 'User unbanned successfully!');
    }

    public function create()
    {
        return view('dashboard.create-user');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required|string|unique:users,staff_id|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'othername' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'role' => 'required|in:staff,admin',
            'password' => 'required|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $userData = [
            'staff_id' => $request->staff_id,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'othername' => $request->othername,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ];

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('profile-images', $fileName, 'public');
            
            $upload = Upload::create([
                'url' => $filePath
            ]);
            
            $userData['upload_id'] = $upload->id;
        }

        User::create($userData);

        return redirect()->route('user-management.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return view('dashboard.edit-user', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required|string|unique:users,staff_id,' . $user->id . '|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'othername' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id . '|max:255',
            'role' => 'required|in:staff,admin',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $userData = [
            'staff_id' => $request->staff_id,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'othername' => $request->othername,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('profile-images', $fileName, 'public');
            
            $upload = Upload::create([
                'url' => $filePath
            ]);
            
            $userData['upload_id'] = $upload->id;
        }

        $user->update($userData);

        return redirect()->route('user-management.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('user-management.index')->with('success', 'User deleted successfully!');
    }
} 