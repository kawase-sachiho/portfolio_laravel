<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ShortSchedule extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    protected $guarded = [
        'id',
        'user_id',
    ];

    protected $casts = [ 
        'registration_date' => 'date', 
        'expire_date'=>'date',
        'finished_date'=>'date',
        ]; 

}
