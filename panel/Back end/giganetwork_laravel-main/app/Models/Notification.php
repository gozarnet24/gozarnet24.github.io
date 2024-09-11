<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Summary of Notification
 *
 * @mixin Builder
 */
class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_notifications')
            ->withPivot('is_read')
            ->withTimestamps();
    }
    
}
