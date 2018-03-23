<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CommentResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"            => $this->id,
            "content"       => $this->content,
            "created_at"    => $this->created_at,
            "file_path"     => $this->file_path,
            "is_best"       => $this->is_best === '1',
            "is_published"  => $this->is_published,
            "is_rejected"   => $this->is_rejected,
        ];
    }
}
