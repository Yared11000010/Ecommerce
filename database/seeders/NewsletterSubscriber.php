<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NewsletterSubscriber extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $subscribersRecords=[
            ['id'=>1,'email'=>'email@gmail.com','status'=>1],
            ['id'=>2,'email'=>'yared@gmail.com','status'=>1],
        ];

        \App\Models\NewsletterSubscriber::insert($subscribersRecords);
    }
}
