<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;
    protected $table = 'user_activities';
    protected $fillable = [
        'user_id',
        'activity_id',
        'title',
        'description',
        'image',
        'date',
        'edited',
    ];
    

    public function userMainActivity()
    {
        return $this->belongsTo(UserMainActivity::class, 'user_id', 'user_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }
}
