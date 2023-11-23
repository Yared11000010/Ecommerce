<?php

namespace Database\Seeders;

use App\Models\DeliveryAddress;
use Illuminate\Database\Seeder;

class DeliveryAddressTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $deliveryRecords=[
        ['id'=>1,'user_id'=>7,'name'=>'Yared Ayele','address'=>'Adama-04','city'=>'Adama','state'=>'Oromia','country'=>'Ethiopia','pincode'=>10001,
          'mobile'=>12651113,'status'=>1
        ],
        ['id'=>2,'user_id'=>1,'name'=>'Betsi Tadesse','address'=>'Adama-04','city'=>'Adama','state'=>'Oromia','country'=>'Ethiopia','pincode'=>1001,
          'mobile'=>25213490,'status'=>1
        ],
          
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}