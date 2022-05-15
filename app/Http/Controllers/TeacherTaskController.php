<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateSolutionRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\ShowTaskResource;
use App\Http\Resources\ShowTeacherTaskResource;
use App\Http\Resources\TeacherTaskResource;
use App\Models\Solution;
use App\Models\Subject;
use App\Models\Task;
use http\Env\Response;


class TeacherTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TeacherTaskResource
     */
    public function index()
    {
        $allTask = Task::all();
        return new TeacherTaskResource($allTask);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreTaskRequest $storeTaskRequest
     * @param $id
     * @return string
     */

    public function createTaskForSubject(StoreTaskRequest $storeTaskRequest, $id)
    {

        $subject = Subject::find($id)->first();
        $createTask = $subject->tasks()->create($storeTaskRequest->all());

        if($createTask){

            return response(['The storage of the task to the subject '. $subject->id .' is a success']);
        }

        return response([
            'message' => 'The task storage is failed'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return ShowTaskResource
     */
    public function showTask($id)
    {
        $taskAndSolutionRelation = Task::with('solutions')->where('id',$id)->first();
        return new ShowTaskResource($taskAndSolutionRelation);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateTaskRequest  $updateTaskRequest
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function updateTask(UpdateTaskRequest $updateTaskRequest, $id)
    {
        $task = Task::where('id',$id)->first();
        if(Subject::find($task->subject_id)->teacher_id==auth()->id()) {
            $updating = $task->update($updateTaskRequest->all());
            if($updating) {
                return response([
                    'The updating is a success'
                ]);
            }

            return response([
                'messagee' => 'We can\'t update the task'
            ]);
        }

        return response([
            'message' => 'Your have not autorised to update this task'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroyTask($id)
    {
        $task = Task::where('id',$id)->first();
        if(Subject::find($task->subject_id)->teacher_id==auth()->id()) {

            $deleting = $task->delete();
            if($deleting) {
                return response([
                    'message' => 'We have delete the task'
                ]);
            }

            return response([
                'message' => 'We can\'t delete the task'
            ]);
        }

        return response([
            'message' => 'Your have not autorised to remove this task'
        ]);
    }

    /**
     * Evaluating the specific solution of a task
     * @param UpdateSolutionRequest $updateSolutionRequest
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */

    public function evaluateSolution(UpdateSolutionRequest $updateSolutionRequest, $id)
    {
        $solution = Solution::where('id',$id)->first();
        $updating = $solution->update([
            'evaluation'=>$updateSolutionRequest->get('evaluation'),
            'evaluated_at'=>now()
        ]);

        if($updating) {
            return response([
                'message' => 'The updating is a success'
            ]);
        }

        return \response([
            'message' => 'The updating is failed'
        ]);
    }


}
