<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OffersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'title'      => $request->header('lang') == 'en' ? $this->title_en : $this->title_ar,
            'title_ar'      => $this->title_ar,
            'title_en'      => $this->title_en,
            'specialty_id' => $this->specialty_id,
            'specialty_name' => optional($this->specialty)->{'name_' . ($request->header('lang') == 'en' ? 'en' : 'ar')},
            'discount'      => $this->discount,
        ];
    }
}
