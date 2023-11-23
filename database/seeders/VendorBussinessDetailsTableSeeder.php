<?php

namespace Database\Seeders;

use App\Models\VendorBussinessDetails;
use Illuminate\Database\Seeder;

class VendorBussinessDetailsTableSeeder extends Seeder
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
            ['id'=>1,'vendor_id'=>3,'shop_name'=>'John Electronics Store','shop_address'=>'123_scf','shop_city'=>'Adama','shop_state'=>'Delhi','shop_country'=>'India',
            'shop_pincode'=>'110001','shop_mobile'=>'9723525254','shop_website'=>'lkfkad.in','shop_email'=>'shop@gmail.com','address_proof'=>'Passport','address_proof_image'=>'test.jpg',
            'business_license_number'=>'12312121','gst_number'=>'324234141','pan_number'=>'42342342343124'
          ],
          ];
          VendorBussinessDetails::insert($vendorRecords);
    }
}