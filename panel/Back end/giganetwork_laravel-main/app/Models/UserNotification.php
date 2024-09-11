<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserNotification extends Pivot
{
    protected $table = 'user_notifications';

    protected $fillable = ['user_id', 'notification_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
