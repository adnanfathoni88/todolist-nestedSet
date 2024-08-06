<?php

namespace Modules\Task\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Task\Database\Factories\TaskFactory;

class Task extends Model
{
    use HasFactory;
    use NodeTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'task';
    protected $fillable = ['name', 'description', 'level', 'parent_id'];

    public function children()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function subTasks()
    {
        return $this->hasMany(Task::class, 'parent_id')->with('children');
    }
}
