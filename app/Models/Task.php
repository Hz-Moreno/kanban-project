<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['title', 'board_id', 'user_id', 'description', 'position', 'priority'];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
