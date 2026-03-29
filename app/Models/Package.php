<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'title',
        'sessions_number',
        'session_duration',
        'price',
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public static function rules()
    {
        return [

            "title" => [
                'required',
                'string',
                'min:3',
                'max:255',

            ],

            "session_duration" => [
                'required',
                'string',
                'min:1',
                'max:255',

            ],


            "sessions_number" => [
                'required',
                'numeric',
                'min:1',
                'max:500'
            ],
            "price" => [
                'required',
                'numeric',
                'min:1',
                'max:500'
            ],

        ];
    }
}
