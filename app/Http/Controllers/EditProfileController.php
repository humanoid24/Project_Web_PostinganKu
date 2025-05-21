<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    public function index()
    {
        return view('halaman.edit-profile');
    }

    public function update(Request $request, User $user)
    {

        $rules = [];

        if ($request->filled('name') && $request->name !== $user->name) {
            $rules['name'] = 'required|max:255';
        }

        if ($request->filled('email') && $request->email !== $user->email) {
            $rules['email'] = 'required|max:255|email|unique:users';
        }

        if ($request->filled('password')) {
            $rules['password'] = 'min:4|confirmed';
        }

        $validate = $request->validate($rules);

        $data = [];

        if (isset($validate['name'])) {
            $data['name'] = $validate['name'];
        }

        if (isset($validate['email'])) {
            $data['email'] = $validate['email'];
        }

        if (!empty($validate['password'])) {
            $data['password'] = Hash::make($validate['password']);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $fotoPath = $request->file('foto')->store('foto_profile', 'public');
            $data['foto'] = $fotoPath;
        }

        if (!empty($data)) {
            $user->update($data);
        }

        return redirect()->back()->with('success', 'Profile berhasil diperbarui.');
    }
}
