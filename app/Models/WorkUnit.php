<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkUnit extends Model
{
    protected $guarded = [];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
