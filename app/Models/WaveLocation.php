<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaveLocation extends Model
{
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(Wave::class, 'IdWave', 'IdWave');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'IdLocation', 'IdLocation');
    }
    public function sons(){
        return $this->hasMany(WaveEmployee::class, 'IdWave', 'IdWaveLocation');
    }
}
