<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'is_completed',
        'is_urgently',
        'creator_id',
        'is_sent_vk_notification',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
