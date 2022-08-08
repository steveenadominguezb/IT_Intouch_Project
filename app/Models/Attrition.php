<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attrition extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'cde', 'cde');
    }

    public function computer()
    {
        return $this->belongsTo(Computer::class, 'SerialNumber', 'SerialNumber');
    }

    public function newComputer()
    {
        return $this->belongsTo(Computer::class, 'NewSerialNumber', 'SerialNumber');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'IdProgram', 'IdProgram');
    }
}
