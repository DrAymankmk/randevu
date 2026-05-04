<?php

namespace App\Http\Controllers\AdminPanel\MainAdmin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityControllerController extends Controller
{
    // get cities
    function index()
    {
        $data['cities'] = City::withCount('clinics')->latest()->get();
        return view('main_admin.cities', compact('data'));
    }


    // add city
    public function add_city(Request $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['country_id'] = 1;
        $add_city = City::create($data);
        if ($add_city) {
            session()->flash('success', trans('messages.Added'));
            return redirect()->back();
        }
    }

    //Edit specialty
    public function update_city($id, Request $request)
    {
        $edit_city = City::where('id', $id)->first();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $edit_city->update($data);
        session()->flash('success', trans('messages.updated'));
        return redirect()->back();
    }


    // delete city
    function destroy_city($id)
    {
        $city = City::where('id', $id)->first();
        $city->delete();
        session()->flash('success', trans('messages.deleted'));
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $cities = City::where('name_ar', 'LIKE', "%{$query}%")
            ->orWhere('name_en', 'LIKE', "%{$query}%")
            ->get();

        return view('main_admin.partials.cities-list', compact('cities'))->render();
    }
}
