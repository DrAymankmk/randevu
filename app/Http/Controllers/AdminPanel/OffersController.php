<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddDepartment;
use App\Http\Requests\Admin\AddTitle;
use App\Http\Requests\Admin\CreateTeam;
use App\Models\AppType;
use App\Models\ClinicOffer;
use App\Models\ClinicSpecialist;
use App\Models\CountryAds;
use App\Models\Report;
use App\Models\Specialty;
use App\Repositories\App\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OffersController extends Controller
{
    protected function clinicSpecialtyIds($clinicId)
    {
        return ClinicSpecialist::where('clinic_id', $clinicId)
            ->where('type', 1)
            ->where('status', 1)
            ->pluck('specialty_id');
    }

    // show offers

    function index()
    {
        $auth_user = Auth::user()->app_type == 7 ? Auth::user()->id : Auth::user()->parent_id;

        $specialtyIds = $this->clinicSpecialtyIds($auth_user);

        $data['specialties'] = Specialty::whereIn('id', $specialtyIds)
            ->where('status', 1)
            ->orderBy('name_ar')
            ->get();

        $data['offers'] = ClinicOffer::with('specialty')
            ->where('clinic_id', $auth_user)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('offers.index', compact('data'));
    }

    // add offers
    public function add_offer(AddTitle $request)
    {
        $request->validate([
            'discount' => 'required|integer|min:1|max:100',
            'specialty_id' => 'required|exists:specialties,id',
        ]);

        $auth_user = Auth::user()->app_type == 7 ? Auth::user()->id : Auth::user()->parent_id;
        if (!$this->clinicSpecialtyIds($auth_user)->contains((int) $request->specialty_id)) {
            throw ValidationException::withMessages([
                'specialty_id' => trans('admin.specialties'),
            ]);
        }

        $data = $request->all();
        $data['clinic_id'] = $auth_user;
        $add_offer = ClinicOffer::create($data);
        if ($add_offer) {
            session()->flash('success', trans('messages.Added'));
            return redirect()->back();
        }
    }

    //Edit city
    public function edit_offer($id, AddTitle $request)
    {
        $request->validate([
            'discount' => 'required|integer|min:1|max:100',
            'specialty_id' => 'required|exists:specialties,id',
        ]);

        $auth_user = Auth::user()->app_type == 7 ? Auth::user()->id : Auth::user()->parent_id;
        if (!$this->clinicSpecialtyIds($auth_user)->contains((int) $request->specialty_id)) {
            throw ValidationException::withMessages([
                'specialty_id' => trans('admin.specialties'),
            ]);
        }

        $edit_offer = ClinicOffer::where('id', $id)->first();
        $data = $request->all();
        $edit_offer->update($data);
        session()->flash('success', trans('messages.updated'));
        return redirect()->back();
    }

    public function update_status_offer($id, $status)
    {
        $status_ffer = ClinicOffer::where('id', $id)->first();
        $status_ffer->status = $status;
        $status_ffer->save();
        session()->flash('success', trans('messages.update_status'));
    }


    // delete offer
    function destroy_offer($id)
    {
        $offer = ClinicOffer::where('id', $id)->first();
        $offer->delete();
        session()->flash('success', trans('messages.deleted'));
        return redirect()->back();
    }
}
