<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedicalReport extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'report_id', 'answer_id','parent_id', 'reason', 'report_type', 'answer_flag'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function patient_report()
    {
        return $this->hasMany(PatientMedicalReport::class, 'parent_id');
    }

    public function medical_report()
    {
        return $this->belongsTo(MedicalReport::class, 'report_id');
    }

}
