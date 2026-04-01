<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',

        'trainer_package_id',
        'status',
        'date',             // تاريخ الحجز
        'time',             // وقت الحجز
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function trainerPackage()
    {
        return $this->belongsTo(TrainerPackage::class, 'trainer_package_id');
    }
    public static function rules()
    {
        return [

            "user_id" => [
                'required',
                'integer',
                'exists:users,id',
            ],

            "trainer_package_id" => [
                'required',
                'integer',
                'exists:trainer_packages,id',
            ],
            'date' => [
                'required',
                'date',
            ],
            'time' => [
                'required',
            ],

        ];
    }
}
