<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'observation' => $this->observation,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'owner' => User::find($this->owner_id),
            'responsible' => User::find($this->responsible_id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
