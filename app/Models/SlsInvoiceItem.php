<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlsInvoiceItem extends Model
{
  //  use HasFactory;
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo('App\Models\SlsInvoice');
    }
    protected $appends = ['produced', 'delivered',  'remain'];

    public function product()
    {
        return $this->belongsTo('App\Models\StrProduct', 'str_product_id');
    }


    public function production()
    {
        return $this->hasMany('App\Models\SlsProductionOrder', 'sls_invoice_item_id');
    }


    public function deliveries()
    {
        return $this->hasMany('App\Models\SlsDeliveryItem', 'sls_invoice_item_id');
    }


    public function getDeliveredAttribute()
    {
        return $this->deliveries->sum('quantity');
    }
    public function getProducedAttribute()
    {
        return $this->production->sum('final_quantity');
    }
    public function getRemainAttribute()
    {
        return $this->quantity - $this->deliveries->sum('quantity');
    }
    public function getSlsInvoiceItemIdAttribute()
    {
        return $this->id;
    }
}
