<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Event extends Model
{
    protected $guard = ["created_at", "updated_at"];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
