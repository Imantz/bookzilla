<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;
    
    protected $fillable = ['book_id'];
    
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
