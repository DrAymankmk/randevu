<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\ReservationRate;
use App\Models\Specialty;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorRatingController extends Controller
{
    //  doctors rating
    public function index(Request $request)
    {
        $clinic_id = Auth::user()->app_type == 7 ? Auth::user()->id : Auth::user()->parent_id;
        $query = ReservationRate::with(['doctors','users'])
            ->where('clinic_id', $clinic_id);
        if ($request->search) {
            $query->whereHas('doctors', function($q) use ($request){
                $q->where('name','like','%'.$request->search.'%');
            });
        }

        if ($request->order == 'top') {
            $query->orderByDesc('rate_value');
        }

        $ratings = $query->paginate(10);

        return view('doctors.ratings', compact('ratings'));
    }


}
