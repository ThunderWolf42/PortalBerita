<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
class Author extends Model
{
    use HasFactory , SoftDeletes, HasRoles;


    protected $fillable = [
        'name',
        'occupation',
        'avatar',
        'slug',
    ];


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }


    public function news():HasMany
    {
        return $this->hasMany(ArticleNews::class, 'author_id');
    }
}
