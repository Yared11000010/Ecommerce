<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBussinessDetails extends Model
{
    use HasFactory;
    protected $table='vendors_business_details';
    protected  $fillable=[
            'vendor_id',
            'shop_name',
            'shop_address',
            'shop_city',
            'shop_image',
            'shop_state',
            'shop_country',
            'shop_pincode',
            'shop_mobile',
            'shop_website',
            'shop_email',
            'address_proof',
            'address_proof_image',
            'business_license_number',
            'gst_number',
            'pan_number',
      ];
}
