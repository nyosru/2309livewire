<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'created_at' => $this->created_at->toDateTimeString(),
            'ar_object_id' => $this->ar_object_id,
            'ar_people_id' => $this->ar_people_id,
            'ar_people_name' => $this->arPeople->name ?? null, // Если в модели ArPeople есть поле name
        ];
    }
}
