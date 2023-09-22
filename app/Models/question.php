<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $primaryKey = 'id';

    public function options()
    {
        return $this->hasMany(option::class, 'questionId','id');
    }

    public function poll()
    {
        return $this->hasManyThrough(
            poll::class,
            pollQuestion::class,
            'questionId',
            'id',
            'id',
            'pollId',
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
