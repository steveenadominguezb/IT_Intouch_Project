<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaveEmployee extends Model
{
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(WaveLocation::class, 'IdWave', 'IdWaveLocation');
    }

    public function computer()
    {
        return $this->belongsTo(Computer::class, 'SerialNumberComputer', 'SerialNumber');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'cde', 'cde');
    }
}
