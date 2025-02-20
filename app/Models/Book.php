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
            ->when($filters['q'] ?? false, fn ($query) => $query->where(function ($q) use ($filters) {
                $searchTerm = strtolower($filters['q']);
                $q->where('title', 'ILIKE', "%{$searchTerm}%")
                  ->orWhereHas('authors', fn ($q) => $q->where('name', 'ILIKE', "%{$searchTerm}%"));
            }))
            ->when(
                $filters['date_from'] || $filters['date_to'], 
                fn ($query) => $query->whereBetween('purchases.created_at', [
                    $filters['date_from'] ?? now()->subMonth()->toDateString() . ' 00:00:00',
                    $filters['date_to'] ?? now()->toDateString() . ' 23:59:59'
                ])
            )
            ->when(
                isset($filters['sort_by']), 
                fn ($query) => $query->orderBy(
                    $filters['sort_by'],
                    in_array(strtolower($filters['sort_order'] ?? 'asc'), ['asc', 'desc']) ? strtolower($filters['sort_order']) : 'asc'
                )
            )
            ->when(
                isset($filters['limit']) && is_int($filters['limit']) && $filters['limit'] > 0,
                fn ($query) => $query->limit($filters['limit'])
            );
    }
    
}

