<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'image',
        'publish_date',
        'type',
        'description',
        'editor',
        'language',
        'owner_id',
        'copys',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
