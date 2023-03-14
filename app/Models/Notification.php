<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends ALL
{
    use HasFactory;
    protected $guarded = [];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
