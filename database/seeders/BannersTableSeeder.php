<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionRecords=[
            ['id'=>1,'image'=>'banner1.png','link'=>'Spring-collection','type'=>'Fixed', 'title'=>'Spring','alt'=>'spring','status'=>1],
            ['id'=>2,'image'=>'grade.png','link'=>'Spring-collection', 'type'=>'Fixed', 'title'=>'Spring','alt'=>'spring','status'=>1],
            ['id'=>3,'image'=>'fruit.png','link'=>'Spring-collection', 'type'=>'Fixed', 'title'=>'Spring','alt'=>'spring','status'=>1],

          ];
          Banner::insert( $sectionRecords);
    }
}