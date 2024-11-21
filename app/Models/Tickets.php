<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'about', 'status', 'user_id', 'priority'];

    public function user()
{
    return $this->belongsTo(User::class);
}
}