<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /** @var 値を反映したくないフィールド */
    protected $guarded = [
        'id',
        'user_id',
    ];
    protected $casts = [ 
        'registration_date' => 'date',
        ]; 

    /* 1対多の関係で結びつく */
    public function category_note(){
        return $this->hasMany(\App\Models\Note::class); 
    }

}
