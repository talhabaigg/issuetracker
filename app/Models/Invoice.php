<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['customer_name', 'invoice_date'];

    public function lineItems()
    {
        return $this->hasMany(LineItem::class);
    }
}
