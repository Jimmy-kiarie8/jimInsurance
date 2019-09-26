<?php

namespace App\Imports;

use App\Smscontact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Smscontact([
            'name'     => $row[0],
            'phone'    => $row[1],
            'group' => $row[2],
        ]);
    }
}
