<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
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
        $completed = $request->input()['completed'] ?? null;
        $name = $request->input()['name'] ?? null;
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
