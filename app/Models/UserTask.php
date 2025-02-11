<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Task\Models\Task;

class UserTask extends Model
{
    use HasFactory;
    protected $table = 'user_task';

    protected $fillable = [
        'user_id',
        'task_id',
        'is_done',
        'updated_by',
    ];

    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
