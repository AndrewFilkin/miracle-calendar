<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterLink extends Model
{
    use HasFactory;

    protected $table = 'register_links';

    protected $fillable = ['code'];
}
