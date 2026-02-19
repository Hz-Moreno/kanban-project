<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Board;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
