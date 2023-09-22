<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class participatequestion extends Model
{
    use HasFactory;

    protected $table = 'participatequestions';

    protected $primaryKey = 'id';

    protected $fillable = ['optionId', 'questionId','userId'];
}
