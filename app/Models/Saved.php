<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saved extends Model
{
    use HasFactory;

    protected $fillable = ['blogger_id', 'user_id'];

    public function blogger()
    {
        return $this->belongsTo(Blogger::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
