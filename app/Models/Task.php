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

    public static $filterable = [
        'id',
        'user_id',
        'group_id',
        'due_date',
        'is_completed'
    ];

    public static $sortable = [
        'id',
        'created_at',
        'updated_at',
        'due_date',
        'title'
    ];

    public static $searchable = [
        'title',
        'description'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
