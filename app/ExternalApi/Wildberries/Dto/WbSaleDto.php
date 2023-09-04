<?php

namespace App\ExternalApi\Wildberries\Dto;

use App\ExternalApi\Wildberries\Repositories\WbRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class WbSaleDto
{
    private string $date;
    private string $article;
    private string $barcode;
    private string $category;
    private string $brand;
    private string $subject;
    private string $source;
    private string $hash;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->$key($value);
        }

        $this->hash = sha1($data['saleID']);
        $this->source = WbRepository::class;
    }

    public function __call(string $name, array $arguments): void
    {
        $name = Str::camel($name);

        if (property_exists(self::class, $name)) {
            $this->$name = $arguments[0];
        }
    }

    public function date($value): void
    {
        $this->date = Carbon::parse($value)->format('Y-m-d');
    }

    public function supplierArticle($value): void
    {
        $this->article = $value;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

}
