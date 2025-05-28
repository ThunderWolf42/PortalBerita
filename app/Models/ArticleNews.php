<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ArticleNews extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'content',
        'category_id',
        'user_id',
        'status',
        'is_featured',
    ];



    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function author():BelongsTo
    {
        return $this->belongsTo(Author::class , 'user_id');
    }

}
