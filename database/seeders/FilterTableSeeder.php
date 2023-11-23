<?php

namespace Database\Seeders;

use App\Models\ProductFilter;
use Illuminate\Database\Seeder;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $filterRecords=[
          ['id'=>1,'cat_ids'=>'1,2,3,6,7,8','filter_name'=>'Fabric','filter_column'=>'fabric','status'=>1],  
          ['id'=>2,'cat_ids'=>'4,5','filter_name'=>'RAM','filter_column'=>'ram','status'=>1],  

        ];
        ProductFilter::insert($filterRecords);
    }
}