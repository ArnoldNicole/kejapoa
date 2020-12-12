<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use App\Http\Resources\Contact;

class User extends JsonResource
{
    public $preserveKeys = true;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'name'=>$this->name,
            'email'=>$this->email,            
            'username'=>$this->username,            
            'profile_image'=>$this->profile_image,
            'is_verified'=>$this->is_verified,
            'krapin'=>$this->krapin,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_landlord' => $this->is_landlord,
            'contact' => $this->contact,
        ];
    }
}
