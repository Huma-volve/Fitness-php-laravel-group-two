<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerPackage extends Model
{
    protected $fillable = [
        'trainer_id',
        'package_id',
        
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
