<?php

namespace App\Http\Requests\Clinics;

use App\Http\Requests\Request;

class UpdateOrCreateOffersRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'discount' => ['required', 'integer'],
            'title_ar' => ['required', 'string'],
            'title_en' => ['required', 'string'],
            'specialty_id' => ['required', 'exists:specialties,id'],
            'offer_id' => ['nullable', 'exists:clinic_offers,id'],
        ];
    }

    public function messages()
    {
        return [
            'discount.required' => trans('messages.offers.discount'),
            'title_ar.required' => trans('messages.offers.title_ar'),
            'title_en.required' => trans('messages.offers.title_en'),
            'specialty_id.required' => trans('admin.specialties'),
            'offer_id.required' => trans('messages.offers.id'),
        ];
    }


}
