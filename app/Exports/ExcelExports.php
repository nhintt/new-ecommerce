<?php

namespace App\Exports;

use App\UserMailChimpModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UserMailChimpModel::select('customer_email','customer_name','customer_phone')->get();

    }
}
