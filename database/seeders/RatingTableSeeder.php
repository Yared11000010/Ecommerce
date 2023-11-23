<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;
class RatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ratingRecords=[
            ['id'=>1,'user_id'=>1,'product_id'=>1,'review'=>'very good product','rating'=>4,'status'=>0],
            ['id'=>2,'user_id'=>1,'product_id'=>2,'review'=>'very good product','rating'=>4,'status'=>0],
            ['id'=>3,'user_id'=>2,'product_id'=>4,'review'=>'good product','rating'=>3,'status'=>1],
        ];
        Rating::insert($ratingRecords);
    }
}
