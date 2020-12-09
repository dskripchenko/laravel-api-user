<?php

namespace Dskripchenko\LaravelApiUser\Api\Resources;

class User extends \Illuminate\Http\Resources\Json\JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'is_confirmed' => $this->is_confirmed,
            'options' => $this->getOptions(),
        ];
    }
}
