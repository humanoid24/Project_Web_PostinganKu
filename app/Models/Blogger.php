<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogger extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'judul', 'isi_konten', 'media'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function komentar()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function savedPost()
    {
        return $this->hasMany(Saved::class);
    }

    public function laporan()
    {
        return $this->hasMany(LaporanBlogger::class);
    }
}
