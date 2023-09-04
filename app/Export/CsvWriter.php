<?php

namespace App\Export;

use Illuminate\Database\Eloquent\Collection;
use League\Csv\Writer;

class CsvWriter
{
    public function make(Collection $sales, $filePath): void
    {
        $rows = $sales->map(fn($row) => ['', $row->article, $row->subject, $row->date]);

        $csv = Writer::createFromPath($filePath, 'w+');
        $csv->setDelimiter(';');
        $csv->insertOne(['', 'article', 'subject', 'date']);
        $csv->insertAll($rows);

        unset($csv);
    }
}
