<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanBlogger extends Model
{
    use HasFactory;

    protected $fillable = ['blogger_id', 'user_id', 'to_user_id', 'alasan', 'status', 'is_read'];

    public function blogger()
    {
        return $this->belongsTo(Blogger::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function terlapor()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
