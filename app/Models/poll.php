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
            'pollId', // foreign key on the intermediate table reference local for current
            'id', // foreign key of final model reference intermediate local key
            'id', //local key on the current
            'questionId',  // local key on intermediate
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
