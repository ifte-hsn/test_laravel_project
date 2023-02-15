<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'mandatory',
        'quiz_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'quiz_id'
    ];

    protected $casts = [
        'mandatory' => 'boolean',
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

}
