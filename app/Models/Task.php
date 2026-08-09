<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

    protected $attributes = [
        'status' => TaskStatus::Pending->value,
    ];

    public function scopeStatus(Builder $query, TaskStatus $status): Builder {
        return $query->where('status', $status);
    }
}
