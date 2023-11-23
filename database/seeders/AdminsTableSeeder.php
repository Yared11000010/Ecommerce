<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords=[
            ['id'=>4,'name'=>'John','vendor_id'=>1,'type'=>'Admin','mobile'=>'0912651113','email'=>'yared@gmail.com','password'=>'$2a$12$Z8pBFNnYF2fYSD5fwfjGCOyyVkiXVkgiRO5xhkGXhhWMstrgTHCY2',
            'image'=>'','status'=>1],
        ];
        Admin::insert($adminRecords);
        //
    }
}