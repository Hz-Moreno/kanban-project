<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    public function tasks(): HasMany{
        return $this->hasMany(Task::class)->orderBy('position')
    }
}
