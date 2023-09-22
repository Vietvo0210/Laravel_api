<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 */
class Test extends Model
{
    use HasFactory;

    protected $table = 'test';

    protected $fillable = [
        'name',
    ];
}
