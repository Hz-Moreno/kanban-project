<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Board;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kanban extends Model
{
    public function boards(): HasMany {
        return $this->hasMany(Board::class)->orderBy('position')
    }
}
