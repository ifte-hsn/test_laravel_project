<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "right_answer",
        "question_id"
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'question_id'
    ];


    protected $casts = [
        'right_answer' => 'boolean',
    ];
}
