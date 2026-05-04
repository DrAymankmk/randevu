<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientSaleInvoice extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "patient_sale_invoices";

    protected $guarded = [];

    public function patientInvoiceItems()
    {
        return $this->hasMany('App\Models\PatientSaleInvoiceItem','patient_sale_invoice_id');
    }


}
