<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

   

    public function userActivities()
    {
        return $this->hasMany(UserActivity::class, 'user_id', 'user_id');
    }
}
