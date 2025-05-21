<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['blogger_id', 'user_id', 'isi'];

    public function blogger()
    {
        return $this->belongsTo(Blogger::class, 'blogger_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
