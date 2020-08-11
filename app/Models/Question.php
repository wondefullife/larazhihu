<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'best_answer_id'
    ];
    protected $casts = [
        'published_at' => 'datetime',
    ];
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull('published_at');
    }

    public function markAsBestAnswer(Answer $answer)
    {
        $this->update([
            'best_answer_id' => $answer->id
        ]);
    }
}
