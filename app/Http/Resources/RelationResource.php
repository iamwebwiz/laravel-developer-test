<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RelationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'relative' => $this->relative,
            'relationship' => $this->relationship,
        ];
    }
}
