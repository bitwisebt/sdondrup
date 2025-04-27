<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //----- Profile--------//
    public function index()
    {
        $id = Auth::user()->id;
        $profile = User::find($id);
        return view('profile.edit', compact('profile'));
    }
    public function update($id, Request $request)
    {
        if ($request->input('email') == Auth::user()->email) {
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255']
            ]);
        } else {
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
            ]);
        }

        // Save information about the uploaded document to the database
        $data = User::find($id);
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        if ($request->hasFile('profile')) {
            $path = 'public/profile/';
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }
            // Get just ext 
            $extension = $request->file('profile')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $request->input('profile') . preg_replace('/\s+/', '_', $request->input('name')) . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('profile')->storeAs($path, $fileNameToStore);
            $data->image_path = 'storage/profile/' .  $fileNameToStore;
        }
        $data->save();
        return redirect('/home')->with('success', 'Updated successfully');
    }
}
