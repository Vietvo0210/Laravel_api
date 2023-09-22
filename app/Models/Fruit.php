<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property string season
 * @property int $amount
 */
class Fruit extends Model
{
    use HasFactory;

    protected $table = 'fruit';

    protected $fillable = [
        'name',
        'type',
        'season',
        'amount'
    ];
}
