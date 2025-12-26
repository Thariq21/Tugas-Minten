<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'excerpt',
        'body',
        'kategori',
        'bigimage',
        'thumbimage',
        'figcaption'
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk format tanggal yang lebih readable
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d F Y');
    }

    // Method untuk generate slug otomatis
    public static function generateSlug($judul)
    {
        $slug = Str::slug($judul);
        $count = static::where('slug', 'LIKE', "{$slug}%")->count();
        
        return $count ? "{$slug}-{$count}" : $slug;
    }
}