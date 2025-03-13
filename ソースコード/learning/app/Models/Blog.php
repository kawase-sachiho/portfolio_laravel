<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Blog extends Model
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
        'learning_date'=>'date',
        ]; 

}
