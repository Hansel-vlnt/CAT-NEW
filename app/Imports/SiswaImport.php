<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //
        return new User([
            'id_kelas' => $row[0],
            'nama'     => $row[1], 
            'no_induk' => $row[2], 
            'nisn'     => $row[3], 
            'jk'       => $row[4], 
            'status'   => 'S',
            'status_sekolah'  => 'Y', 
            'email'  => trim(strtolower($row[2])) + mt_rand(1000000000, mt_getrandmax()) . '@abdipraja.co.id', 
            'password' => bcrypt(123456),
         ]);
    }
}
