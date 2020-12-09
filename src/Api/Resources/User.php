<?php

namespace Dskripchenko\LaravelApiUser\Api\Resources;

class User extends \Illuminate\Http\Resources\Json\JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'options' => $this->getOptions(),
        ];
    }
}
