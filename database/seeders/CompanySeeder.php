<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            'SMC','Eaton','Siemens','Carl Valentin','Weidmüller','BOS','Lipowsky','Omron','Keyence','Moxa','Festo', 'Pepperl+Fuchs', 'HBM'
        ];

        foreach ($list as $key => $value) {
            Company::create(["name" => $value]);
        }

    }
}
