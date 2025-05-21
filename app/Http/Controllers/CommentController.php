<?php

namespace App\Http\Controllers;

use App\Models\Blogger;
use App\Models\Comment;
use App\Models\LaporanKomentar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'blogger_id' => 'required|exists:bloggers,id',
            'isi' => 'required|string|max:1000'
        ]);

        $blogger = Blogger::findOrFail($validate['blogger_id']);

        $blogger->komentar()->create([
            'blogger_id' => $blogger->id, // atau langsung pakai $blogger->id
            'user_id' => Auth::id(),
            'isi' => $validate['isi'],
        ]);

        return redirect()->route('bloggers.show', $blogger->id)->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'isi' => 'required|string|max:1000'
        ]);

        // Cari komentar berdasarkan ID
        $komentar = Comment::findOrFail($id);

        // (Opsional) Pastikan user hanya bisa edit komentarnya sendiri
        if ($komentar->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit komentar ini.');
        }

        // Update isi komentar
        $komentar->update([
            'isi' => $validate['isi'],
        ]);

        return redirect()->route('bloggers.show', $komentar->blogger_id)
            ->with('success', 'Komentar berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $komentar = Comment::findOrFail($id);
        $userid = Auth::user();

        // (Opsional) Pastikan hanya pemilik komentar atau admin yang bisa hapus
        if ($komentar->user_id !== Auth::id() && $userid->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }

        $komentarId = $komentar->blogger_id;

        $komentar->delete();

        return redirect()->route('bloggers.show', $komentarId)
            ->with('success', 'Komentar berhasil dihapus!');
    }


    public function reportcomment(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|in:spam,pelecehan,komentar tidak pantas,lainnya',
        ]);

        $komentar = Comment::findOrFail($id);

        if (Auth::id() === $komentar->user_id) {
            return back()->with('error', 'Tidak bisa melaporkan komentar sendiri.');
        }

        $sudahLapor = LaporanKomentar::where('comment_id', $id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($sudahLapor) {
            return back()->with('warning', 'Kamu sudah pernah melaporkan komentar ini.');
        }

        LaporanKomentar::create([
            'comment_id' => $id,
            'user_id' => Auth::id(),
            'to_user_id' => $komentar->user_id,
            'alasan' => $request->alasan,
        ]);

        return back()->with('success', 'Komentar berhasil dilaporkan.');
    }
}
