<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $casts = [
        'published_at' => 'datetime'
    ];
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull('published_at');
    }
}
