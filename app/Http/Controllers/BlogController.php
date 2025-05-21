<?php

namespace App\Http\Controllers;

use App\Models\Blogger;
use App\Models\LaporanBlogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        return redirect()->route('bloggers.index')->with('success', 'Thread berhasil diposting!');
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
        return redirect()->route('bloggers.show', $blogger)->with('success', 'Postingan berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blogger $blogger)
    {
        $blogger->delete();
        return redirect()->route('bloggers.index', $blogger)->with('success', 'Postingan berhasil dihapus!');
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
            return back()->with('warning', 'Kamu sudah pernah melaporkan blogger ini.');
        }

        LaporanBlogger::create([
            'blogger_id' => $id,
            'user_id' => Auth::id(),
            'to_user_id' => $blogger->user_id,
            'alasan' => $request->alasan,
        ]);

        return back()->with('success', 'Komentar berhasil dilaporkan.');
    }
}
