<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CmsPage;
class CmsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cmsPagesRecords=[
          [
            'id'=>1, 'title'=>'About Us','description'=>'Content is Coming soon','url'=>'about-us',
            'meta_title'=>'About Us','meta_description'=>'About Multivendor Website','meta_keywords'=>'about us, about ecommerce','status'=>1
          ],
            [
                'id'=>2, 'title'=>'Privacy Policy','description'=>'Content is Coming soon','url'=>'privacy-policy',
                'meta_title'=>'Privacy Policy','meta_description'=>'Privacy Policy of Multivendor Website','meta_keywords'=>'privacy policy','status'=>1
            ],

        ];
        Cmspage::insert($cmsPagesRecords);
    }
}
