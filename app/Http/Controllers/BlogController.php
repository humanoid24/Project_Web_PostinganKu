<?php

namespace App\Http\Controllers;

use App\Models\Blogger;
use App\Models\LaporanBlogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dashboard = Blogger::latest()->paginate(20);
        return view('halaman.dashboard', compact('dashboard'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('halaman.crudblog.addblog');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'judul' => 'required|string|max:30',
                'isi' => 'required|string',
                'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,webm|max:51200',
            ]);

            // video atau foto
            $mediaPath = null;

            if ($request->hasFile('media')) {
                $mediaPath = $request->file('media')->store('media', 'public');
            }


            // Buat ke dalam database
            Blogger::create([
                'user_id' => Auth::id(),
                'judul' => $validate['judul'],
                'isi_konten' => $validate['isi'],
                'media' => $mediaPath,
            ]);
            Session::flash('message', 'Status berhasil diposting');
            return redirect()->route('bloggers.index');
        } catch (ValidationException $e) {
            if ($e->validator->errors()->has('media')) {
                Session::flash('error', 'Media gagal diupload. Ukuran file maksimal 50 MB dan format harus jpg, jpeg, png, mp4, atau webm.');
            } else {
                Session::flash('error', 'Gagal memposting status. Periksa kembali isian form.');
            }
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Blogger $blogger)
    {
        $blogger->load(['user', 'likes', 'savedPost']);
        return view('halaman.showpostingan', compact('blogger'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blogger $blogger)
    {
        return view('halaman.crudblog.editblog', compact('blogger'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blogger $blogger)
    {
        try {
            $validate = $request->validate([
                'judul' => 'required|string',
                'isi' => 'required|string',
                'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,webm|max:51200',
            ]);

            // video atau foto
            $mediaPath = $blogger->media;

            if ($request->hasFile('media')) {
                if ($blogger->media) {
                    Storage::disk('public')->delete($blogger->media);
                }
                $mediaPath = $request->file('media')->store('media', 'public');
            }

            $blogger->update([
                'judul' => $validate['judul'],
                'isi_konten' => $validate['isi'],
                'media' => $mediaPath,
            ]);
            
            Session::flash('message', 'Status berhasil diedit');
            return redirect()->route('bloggers.show', $blogger);
            
        } catch (ValidationException $e) {

            if ($e->validator->errors()->has('media')) {
                Session::flash('error', 'Media gagal diupload. Ukuran file maksimal 50 MB dan format harus jpg, jpeg, png, mp4, atau webm.');
            } else {
                Session::flash('error', 'Gagal mengedit status. Periksa kembali isian form.');
            }
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blogger $blogger)
    {
        $blogger->delete();
        Session::flash('message', 'Status berhasil dihapus');
        return redirect()->route('bloggers.index', $blogger);
    }

    public function userPosts($userId)
    {
        // Mendapatkan semua postingan milik user berdasarkan ID user
        $posts = Blogger::where('user_id', $userId)->latest()->paginate(20);

        // Mengarahkan ke view yang sesuai
        return view('halaman.postingansaya', compact('posts'));
    }


    public function reportblogger(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|in:spam,pelecehan,Postingan tidak pantas,lainnya',
        ]);

        $blogger = Blogger::findOrFail($id);

        if (Auth::id() === $blogger->user_id) {
            return back()->with('error', 'Tidak bisa melaporkan blogger sendiri.');
        }

        $sudahLapor = LaporanBlogger::where('blogger_id', $id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($sudahLapor) {
            Session::flash('error', 'Kamu sudah pernah melaporkan blogger ini.');
            return back();
        }

        LaporanBlogger::create([
            'blogger_id' => $id,
            'user_id' => Auth::id(),
            'to_user_id' => $blogger->user_id,
            'alasan' => $request->alasan,
        ]);

        Session::flash('message', 'Status berhasil dilaporkan');
        return back();
    }
}
