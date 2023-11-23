<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $vendorRecords=[
       ['id'=>3,'name'=>'John','address'=>'Post-04','city'=>'Adama','state'=>'Delhi','country'=>'India','pincode'=>'1001',
       'mobile'=>'0912121212','email'=>'vendor@gmail.com','status'=>0],
        ];
        Vendor::insert($vendorRecords);


    }
}