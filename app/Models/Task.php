<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'group_id',
        'description',
        'due_date',
        'is_completed'
    ];

    protected $hidden = [
        'user_id',
    ];

    const filterable = [
        'user_id',
        'group_id',
        'due_date',
        'is_completed'
    ];

    const sortable = [
        'created_at',
        'updated_at',
        'due_date',
        'title'
    ];

    const searchable = [
        'title',
        'description'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
