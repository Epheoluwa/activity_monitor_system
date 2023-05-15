<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMainActivity extends Model
{
    use HasFactory;
    protected $table = 'user_main_activities';
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
