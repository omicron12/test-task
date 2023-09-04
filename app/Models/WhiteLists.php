<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class WhiteLists extends Model
{
    use AsSource;
    use Filterable;

    protected $guarded = [];

    protected array $allowedFilters = [
        'article' => Where::class,
    ];

    protected array $allowedSorts = [

    ];

    public function scopeArticle(Builder $builder, $article, $keyHash)
    {
        $builder
            ->where('article', $article)
            ->where('key_hash', $keyHash);
    }

    public function scopeKeyHash(Builder $builder, $keyHash)
    {
        $builder->where('key_hash', $keyHash);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'article', 'article');
    }
}
