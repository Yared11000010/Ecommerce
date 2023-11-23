<?php

namespace Database\Seeders;

use App\Models\ProductFilterValues;
use Illuminate\Database\Seeder;

class FilterValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $filtervalueRecords=[
            // ['id'=>1,'filter_id'=>1,'filter_value'=>'cotton','status'=>1], 
            ['id'=>2,'filter_id'=>1,'filter_value'=>'polyester','status'=>1],  
            ['id'=>3,'filter_id'=>2,'filter_value'=>'4GB','status'=>1],  
            ['id'=>4,'filter_id'=>2,'filter_value'=>'4GB','status'=>1],  
 
  
          ];
          ProductFilterValues::insert($filtervalueRecords);
    }
}