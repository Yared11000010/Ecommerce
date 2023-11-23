<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductAttributesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $productAttributesRecords=[
 
            ['id'=>1,'product_id'=>2,'size'=>'Small','price'=>100,'stock'=>10,'sku'=>'RC001-S','status'=>1],
            ['id'=>2,'product_id'=>2,'size'=>'Medium','price'=>200,'stock'=>100,'sku'=>'RC001-M','status'=>1],
            ['id'=>3,'product_id'=>2,'size'=>'Large','price'=>2400,'stock'=>19,'sku'=>'RC001-L','status'=>1],
        ];
        ProductAttribute::insert($productAttributesRecords);
    }
}
