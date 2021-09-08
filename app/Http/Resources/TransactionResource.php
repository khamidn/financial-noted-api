<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'tanggal' => $this->tanggal,
            'nominal' => $this->nominal,
            'keterangan' => $this->keterangan,
            'account' => new AccountResource($this->account),
            'category' => new CategoryResource($this->category),
            'sub_category' => new SubCategoriesResource($this->sub_category),
            'tag' => new TagResource($this->tag),
        ];
    }
}
