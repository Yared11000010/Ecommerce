<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categoryRecords=[
               ['id'=>1,'group_id'=>1,'name'=>'T-Shirts',
               'discount'=>0,'description'=>'',
               'url'=>'t-shirts','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
               ['id'=>2,'group_id'=>1,'name'=>'Dress',
               'discount'=>0,'description'=>'',
               'url'=>'dress','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],

        ];
        Category::insert($categoryRecords);
    }
}
