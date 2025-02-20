<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder 
    {
        return $query
            ->when(!empty($filters['q']), function ($query) use ($filters) {
                $searchTerm = strtolower($filters['q']);
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'ILIKE', "%{$searchTerm}%")
                    ->orWhereHas('authors', fn($q) => $q->where('name', 'ILIKE', "%{$searchTerm}%"));
                });
            })
            ->when(!empty($filters['date_from']) || !empty($filters['date_to']), function ($query) use ($filters) {
                $dateFrom = $filters['date_from'] ?? now()->subMonth()->toDateString();
                $dateTo   = $filters['date_to'] ?? now()->toDateString();

                if (!empty($filters['date_from']) || !empty($filters['date_to'])) {
                    $query->whereBetween('purchases.created_at', ["{$dateFrom} 00:00:00", "{$dateTo} 23:59:59"]);
                }
            })
            ->when(!empty($filters['sort_by']), function ($query) use ($filters) {
                $sortOrder = in_array(strtolower($filters['sort_order'] ?? ''), ['asc', 'desc']) ? $filters['sort_order'] : 'asc';
                $query->orderBy($filters['sort_by'], $sortOrder);
            })
            ->when(!empty($filters['limit']), function ($query) use ($filters) {
                $query->limit((int) $filters['limit']);
            });
    }
}

