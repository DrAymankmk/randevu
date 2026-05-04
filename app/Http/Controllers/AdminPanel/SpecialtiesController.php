<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\ClinicSpecialist;
use App\Models\Posts;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecialtiesController extends Controller
{
    // show posts
    function index()
    {
        $auth_user = Auth::user()->app_type == 7 ? Auth::user()->id : Auth::user()->parent_id;
        $specialty_ids = ClinicSpecialist::with('specialties')->where('clinic_id',$auth_user)->where('type', 1)->where('status', 1)->orderBy('id', 'desc')->pluck('specialty_id')->toArray();
        $data['specializations'] = Specialty::where('status', 1)->whereNotIn('id', $specialty_ids)->where('parent_id',null)->orderBy('id', 'desc')->get();

        $data['clinic_specializations'] = ClinicSpecialist::where('clinic_id', $auth_user)->where('type',1)->orderBy('id', 'desc')->paginate(10);
        return view('specialties.index', compact('data'));
    }

    // add specialty
    public function add_specialty(Request $request)
    {
        $auth_user = Auth::user()->app_type == 7 ? Auth::user()->id : Auth::user()->parent_id;
        $data = $request->all();
        $data['clinic_id'] = $auth_user;
        $data['specialty_id'] = $request->specialty_id;
        $data['type'] = 1;
        $add_specialty = ClinicSpecialist::create($data);
        if ($add_specialty) {
            session()->flash('success', trans('messages.Added'));
            return redirect()->back();
        }
    }

    //Edit specialty
    public function update_specialty($id, Request $request)
    {
        $edit_specialty = ClinicSpecialist::where('id', $id)->first();
        $data = $request->all();
        $edit_specialty->update($data);
        session()->flash('success', trans('messages.updated'));
        return redirect()->back();
    }
    // update status ClinicSpecialist
    public function update_status_specialty($id, $status)
    {
        $status_specialty = ClinicSpecialist::where('id', $id)->first();
        $status_specialty->status = $status;
        $status_specialty->save();
        session()->flash('success', trans('messages.update_status'));
    }


    // delete ClinicSpecialist
    function destroy_specialty($id)
    {
        $specialty = ClinicSpecialist::where('id', $id)->first();
        $specialty->delete();
        session()->flash('success', trans('messages.deleted'));
        return redirect()->back();
    }
}
