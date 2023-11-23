<?php

namespace Database\Seeders;

use App\Models\VendorBankDetails;
use Illuminate\Database\Seeder;

class VendorBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $vendorBankRecords=[
            ['id'=>1,'vendor_id'=>3,'account_holder_name'=>'John Albert Stone','bank_name'=>'Awash Bank','account_number'=>'1000083482382328382',
            ],
          ];
          VendorBankDetails::insert($vendorBankRecords);
    }
}