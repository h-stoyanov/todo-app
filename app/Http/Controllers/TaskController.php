<?php

namespace App\Http\Controllers;

use App\Task;
use App\TaskList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:1',
            'list_id' => 'required'
        ]);

        $task = new Task();
        $task->name = $request->input('name');
        $task->task_list_id = TaskList::where('id', $request->input('list_id'))->firstOrFail()->id;
        if ($task->save()){
            return response()->json(['message' => 'Task created.', 'id' => $task->id]);
        }
        return response()->json(['message' => 'Failed to create task'], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $completed = $request->input('completed') ?? null;
        $name = $request->input('name') ?? null;
        if (isset($name))
            $task->name = $name;
        if (isset($completed))
            if ($completed == 'false') $completed = false;
            elseif ($completed == 'true') $completed = true;
            $task->completed = $completed;
        if ($task->save()){
            return response()->json(['message' => 'success']);
        }
        return response()->json(['message' => 'fail'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if ($task->delete()){
            return response()->json(['message' => 'success']);
        }
        return response()->json(['message' => 'fail'], 400);
    }
}
