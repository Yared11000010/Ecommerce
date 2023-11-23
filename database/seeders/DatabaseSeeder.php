<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use App\Models\Vendor;
use App\Models\Rating;
use App\Models\VendorBankDetails;
use App\Models\VendorBussinessDetails;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      // \App\Models\User::factory(10)->create();
      // $this->call(CategoriesTableSeeder::class);
      // $this->call(AdminsTableSeeder::class);
      // $this->call(VendorTableSeeder::class);
      // // $this->call(VendorBussinessDetailsTableSeeder::class);
      // // $this->call(VendorBankDetailsTableSeeder::class);
      // $this->call(ProductTableSeeder::class);
      // $this->call(ProductAttributesTable::class);
      // $this->call(BannersTableSeeder::class);
      // $this->call(FilterTableSeeder::class);
      // $this->call(FilterValuesTableSeeder::class);
      // $this->call(CouponsTableSeeder::class);
      // $this->call(DeliveryAddressTable::class);
      //$this->call(OrderStatusTable::class);
//        $this->call(CmsPagesTableSeeder::class);
//        $this->call(RatingTableSeeder::class);
//        $this->call(WishlistTableSeeder::class);
//        $this->call(ReturnRequestTableSeeder::class);
        $this->call(NewsletterSubscriber::class);
    }
}
