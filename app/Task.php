<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * Get the task list where this task lives.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taskList()
    {
        return $this->belongsTo('App\TaskList');
    }
}
