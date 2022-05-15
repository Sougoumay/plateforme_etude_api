<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowTeacherSubjectResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'code' => $this->code,
            'credit' => $this->credit,
            'user_students' => UserStudentResource::collection($this->userStudents),
            'tasks' => TeacherTaskResource::collection($this->tasks)

        ];
    }
}
