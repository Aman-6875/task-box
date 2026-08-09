<?php

namespace App\Models;

use App\Enums\TaskPriority;
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
        'priority',
        'due_date',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'priority' => TaskPriority::class,
        'due_date' => 'date',
    ];

    protected $attributes = [
        'status' => TaskStatus::Pending->value,
        'priority' => TaskPriority::Medium->value,
    ];

    public function scopeStatus(Builder $query, TaskStatus $status): Builder {
        return $query->where('status', $status);
    }
}
