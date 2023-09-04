<?php

namespace App\Models;

use App\Orchid\Filters\Types\ActiveFilter;
use App\Orchid\Filters\Types\Where;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class Sale extends Model
{
    use AsSource;
    use Filterable;

    protected $guarded = [];

    protected array $allowedFilters = [
        'active' => ActiveFilter::class,
        'article' => Where::class,
        'barcode' => Where::class,
        'subject' => Like::class,
        'category' => Like::class,
        'brand' => Like::class,
    ];

    protected array $allowedSorts = [

    ];

    public function scopeWithKey($query, $keyHash)
    {
        return $query
            ->leftJoin('white_lists', function ($join) use ($keyHash) {
                $join->on('sales.article', '=', 'white_lists.article')
                    ->whereNull('white_lists.deleted_at')
                    ->where('white_lists.key_hash', $keyHash);
            })
            ->select('sales.*',
                DB::raw('CAST(white_lists.article IS NOT NULL AS BOOLEAN) AS active'),
            );
    }

    public function scopeActive($query)
    {
        return $query
            ->where(DB::raw('CAST(white_lists.article IS NOT NULL AS BOOLEAN)'), true);
    }

}
