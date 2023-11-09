<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contests extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'title_locale'
    ];
}
