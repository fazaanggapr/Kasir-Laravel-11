<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class Produk implements ToCollection
{
    /**
     * @param Collection
     */

    public function collection(Collection $collection)
    {
        dd($collection);
    }
}