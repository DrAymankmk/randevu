<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSaleInvoiceItem extends Model
{
    use HasFactory;

    protected $table = "patient_sale_invoice_items";

    protected $guarded = [];

    public $timestamps = false;
}
