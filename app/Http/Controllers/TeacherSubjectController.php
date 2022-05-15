<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Resources\ShowTeacherSubjectResource;
use App\Http\Resources\TeacherSubjectResource;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class TeacherSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $subjects = Subject::all();
        return TeacherSubjectResource::collection($subjects);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function teacherHomePage(){
        $subjects = Subject::where('teacher_id',auth()->id())->get();
        return TeacherSubjectResource::collection($subjects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubjectRequest $subjectRequest)
    {
        $store = Auth::user()->subjectTeachers()->create($subjectRequest->all());
        if($store) {
            return response([
               'The storage is  a success'
            ]);
        }

        return response([
           'The storage is failed'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return ShowTeacherSubjectResource
     */
    public function show(Subject $subject)
    {
        $subjects = Subject::with('userStudents','tasks')->find($subject->id);
        return new ShowTeacherSubjectResource($subjects);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return TeacherSubjectResource
     */
    public function update(UpdateSubjectRequest $updateSubjectRequest, Subject $subject)
    {
        $subject->update($updateSubjectRequest->all());
        return new TeacherSubjectResource($subject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return string
     */
    public function destroy(Subject $subject)
    {
        $destroy = $subject->delete();
        if($destroy) {
            return response([
               'The destroy is a success'
            ]);
        }
        return response([
            'message' => 'We have a problem to destroy the subject'
        ]);
    }
}
