<?php

namespace App\Imports;

use App\Income;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IncomesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $ex = explode(' ', $row['date']);
        $ex1 = explode('/', $ex[0]);
        $day = '20' . $ex1[2] . '-' . $ex1[1] . '-' . $ex1[0];
        $time = $ex[1] . ':00';
        $date = $day . " " . $time;

        $x = str_replace(',', '', $row['amount']);

        // dd($x);

        return new Income([
            "payer" => $row['payer'],
            "ref_num" => $row['ref'],
            "amount" => $x * 100,
            "type" => $row['purpose'],
            "create_at" => $date,
        ]);
    }


    public function headingRow(): int
    {
        return 2;
    }
}
