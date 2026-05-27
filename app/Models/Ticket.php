<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'status',
    ];

    const STATUSES = [
        'Naujas',
        'Vykdomas',
        'Užbaigtas',
    ];

    const STATUS_CLASSES = [
        'Naujas'    => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
        'Vykdomas'  => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        'Užbaigtas' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
    ];

    public function statusClass(): string
    {
        return self::STATUS_CLASSES[$this->status] ?? 'bg-gray-100 text-gray-600';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}