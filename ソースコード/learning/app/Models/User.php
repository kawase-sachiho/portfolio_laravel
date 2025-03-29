<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //全てのテーブルと1対多の関係で結びつく
    public function blog()
    {
        return $this->hasMany(\App\Models\Blog::class);
    }
    public function category()
    {
        return $this->hasMany(\App\Models\Category::class);
    }
    public function long_schedule()
    {
        return $this->hasMany(\App\Models\LongSchedule::class);
    }
    public function note()
    {
        return $this->hasMany(\App\Models\Note::class);
    }
    public function short_schedule()
    {
        return $this->hasMany(\App\Models\ShortSchedule::class);
    }
    public function todo_item()
    {
        return $this->hasMany(\App\Models\TodoItem::class);
    }
}
