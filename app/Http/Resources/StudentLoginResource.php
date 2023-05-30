<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'token' => $this->token,
            'id' => $this->id,
            'student_identification_number' => $this->student_identification_number,
            'name' => $this->name,
            'school_major' => $this->school_major->abbreviated_word,
            'school_class' => $this->school_class->name,
            'phone_number' => $this->phone_number,
        ];
    }
}
