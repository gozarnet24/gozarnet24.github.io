<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Summary of Config
 *
 * @mixin Builder
 */
class Config extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'meta', 'description'];
}
