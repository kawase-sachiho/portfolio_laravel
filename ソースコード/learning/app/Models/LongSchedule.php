<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class LongSchedule extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    /** @var 値を反映したくないフィールド */
    protected $guarded = [
        'id',
        'user_id',
    ];

    /* 値をキャストするプロパティ */
    protected $casts = [ 
        'registration_date' => 'date', 
        'expire_date'=>'date',
        'finished_date'=>'date',
        ]; 

    /* 1対多の関係で結びつき、期限日が前のものから順番に取得する */
    public function schedule()
    {
        return $this->hasMany(\App\Models\ShortSchedule::class)->orderBy('expire_date','asc');
    }
}
