<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wave extends Model
{
    use HasFactory;

    public function programs(){
        return $this->belongsTo(Program::class, 'IdProgram', 'IdProgram');
    }

    public function locations(){
        return $this->hasMany(WaveLocation::class, 'IdWave', 'IdWave');
    }
}
