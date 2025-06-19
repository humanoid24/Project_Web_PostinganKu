<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EditProfileController extends Controller
{
    public function index()
    {
        return view('halaman.edit-profile');
    }

    public function update(Request $request, User $user)
    {

        try {
            $rules = [];

            if ($request->filled('name') && $request->name !== $user->name) {
                $rules['name'] = 'required|max:255';
            }

            if ($request->filled('email') && $request->email !== $user->email) {
                $rules['email'] = 'required|max:255|email|unique:users,email,' . $user->id;
            }

            if ($request->filled('password')) {
                $rules['password'] = 'min:4|confirmed';
            }

            if ($request->hasFile('foto')) {
                $rules['foto'] = 'nullable|file|mimes:jpg,jpeg,png|max:51200';
            }

            $validate = $request->validate($rules);

            $data = [];

            if (isset($validate['name'])) {
                $data['name'] = $validate['name'];
            }

            if (isset($validate['email'])) {
                $data['email'] = $validate['email'];
            }

            if (isset($validate['password'])) {
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

            Session::flash('message', 'Profil berhasil diperbarui.');
            return redirect()->back();
            
        } catch (ValidationException $e) {
            if ($e->validator->errors()->has('foto')) {
                Session::flash('error', 'Foto gagal diupload. Ukuran file maksimal 50 MB dan format harus jpg, jpeg, png.');
            } else {
                Session::flash('error', 'Gagal mengedit profil. Periksa kembali isian form.');
            }
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
        
    }
}
