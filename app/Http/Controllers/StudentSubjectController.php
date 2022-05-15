<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSolutionRequest;
use App\Http\Resources\ShowTaskResource;
use App\Http\Resources\StudentSubjectResource;
use App\Models\Solution;
use App\Models\Subject;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class StudentSubjectController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function studentSubjectRegistered()
    {
        $subjects=Auth::user()->subjectStudents()->with('userTeachers')->get();
        return StudentSubjectResource::collection($subjects);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function showStudentSubjectNotRegistered()
    {
        $subjects = Subject::with('userTeachers')
            ->whereDoesntHave('userStudents',function($key){
                $key->where('student_id',auth()->id());
            })->get();

        return StudentSubjectResource::collection($subjects);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function addSubjectToStudentList($id)
    {
        $subject = Subject::where('id',$id)->first();
        $adding = $subject->userStudents()->attach(auth()->id());

        if($adding) {
            return response([
                'message' => 'The subject has added to your subject list'
            ]);
        }

        return response([
            'message' => 'We can\'t add the subject to your following subject list'
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function removeSubjectToStudentList($id)
    {
        $removed = Auth::user()->subjectStudents()->detach($id);
        if($removed) {
            return response([
                'message' => 'The subject has removed with success to your following subject list'
            ]);
        }

        return response([
            'message' => 'The subject has not remeved to your following subject list'
        ]);
    }

    /**
     * @param $id
     * @return ShowTaskResource
     */
    public function showAnswerToTask($id)
    {
        $questions = Task::with('solutions')->where('id',$id)->first();
//        $subject = Subject::with('userTeachers')->find($questions->subject_id);
//        $teacher = $subject->userTeachers->nom;

        return new ShowTaskResource($questions);
    }

    /**
     * @param StoreSolutionRequest $storeSolutionRequest
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function putAnswerToTask(StoreSolutionRequest $storeSolutionRequest, $id)
    {
        $answer = Solution::create([
            'answer'=>$storeSolutionRequest->get('answer'),
            'student_id'=>auth()->id(),
            'task_id' => $id
        ]);

        if($answer) {
            return response([
                'message' => 'Your answer has submitted with success '
            ]);
        }

        return response([
            'message' => 'Your answer doesn\'t be submit'
        ]);
    }

}
