<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $productrecords=[
            ['id'=>1,'group_id'=>1,'category_id'=>1,'subcategory_id'=>1,'brand_id'=>1,'vendor_id'=>1,'admin_id'=>2,'admin_type'=>'vendor',
            'product_code'=>22,'product_name'=>'laptop','product_color'=>'gray','product_price'=>45000,'product_selling_price'=>43000,'product_discount'=>10,
            'product_weight'=>5,'product_image'=>'','product_video'=>'','description'=>'',
            'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1,
        ],
        ['id'=>2,'group_id'=>1,'category_id'=>1,'subcategory_id'=>1,'brand_id'=>1,'vendor_id'=>1,'admin_id'=>2,'admin_type'=>'admin',
        'product_code'=>22,'product_name'=>'Desktop','product_color'=>'black','product_price'=>15000,'product_selling_price'=>13000,'product_discount'=>5,
        'product_weight'=>10,'product_image'=>'','product_video'=>'','description'=>'',
        'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'NO','status'=>1,
    ],
        ];
        Product::insert($productrecords);
        //
    }
}
