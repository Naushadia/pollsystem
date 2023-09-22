<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poll extends Model
{
    use HasFactory;
    protected $table = 'polls';

    protected $primaryKey = 'id';

    protected $fillable = ['title', 'description'];

    public function poll_questions()
    {
        return $this->hasManyThrough(
            question::class,
            pollQuestion::class,
            'pollId',
            'id',
            'id',
            'questionId'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
