<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
          'id' => $this->id,
          'product_name' => $this->product_name,
          'description' => $this->description,
        ];
    }

    public function with($request)
    {
      return [
        'version' => '1.1.0',
        'author_url' => url('http://jaysoncleofas.com')
      ];
    }
}
