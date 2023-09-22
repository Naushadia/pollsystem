<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pollQuestion extends Model
{
    use HasFactory;

    protected $table = 'poll_questions';

    protected $fillable = ['questionId','pollId'];

    public function poll()
    {
        return $this->belongsTo(poll::class);
    }

    public function option()
    {
        return $this->belongsTo(option::class);
    }
}
