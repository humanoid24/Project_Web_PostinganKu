<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKomentar extends Model
{
    use HasFactory;

    protected $fillable = ['comment_id', 'user_id', 'to_user_id', 'alasan', 'status', 'is_read'];


    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    // Pelapor
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function terlapor()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
