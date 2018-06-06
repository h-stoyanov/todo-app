<?php

namespace App\Http\Controllers;

use App\Exports\TasksExport;
use App\TaskList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TaskListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()){
            $userTaskLists = User::where('id', Auth::id())->first()->taskLists()->where([
                    ['archived', '=', false],
                    ['delete_request', '=', false]
                ])->get();
            return view('tasklist.index', ['lists' => $userTaskLists]);
        } else {
            return view('welcome');
        }
    }


    /**
     * Display archived lists.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive()
    {
        $userTaskLists = User::where('id', Auth::id())->first()->taskLists()->where('archived', true)->get();
        return view('tasklist.archive', ['lists' => $userTaskLists]);
    }

    /**
     * Display requested for deletion lists.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $userTaskLists = User::where('id', Auth::id())->first()->taskLists()->where('delete_request', true)->get();
        return view('tasklist.deleted', ['lists' => $userTaskLists]);
    }

    /**
     * Exports all lists in form of xlsx file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @internal param Excel $excel
     */
    public function exportTasks($id)
    {
        $tasksList = TaskList::where('id', $id)->first();
        $tasks = $tasksList->tasks()->get();
        $fileName = 'tasks-' . $tasksList->name;
        return Excel::download(new TasksExport($tasks), $fileName.'.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|min:1'
        ]);

        $taskList = new TaskList();
        $taskList->name = $request->input('name');
        $taskList->user_id = Auth::id();
        if ($taskList->save()){
            return response()->json(['message' => 'Task list created.', 'id' => $taskList->id]);
        }
        return response()->json(['message' => 'Failed to create task list.'], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param TaskList $taskList
     */
    public function update(Request $request, $id)
    {
        $taskList = TaskList::where('id', $id)->first();
        $archive = $request->input('archive') ?? null;
        $deleteList = $request->input('delete_list') ?? null;
        if (isset($archive)){
            $taskList->archived = intval($archive);
        }
        if (isset($deleteList)){
            $taskList->delete_request = intval($deleteList);
        }
        if ($taskList->tasks()->count() && $taskList->save()){
            return response()->json(['message' => 'Task list modified successfully']);
        }
        return response()->json(['message' => 'Cannot update task list'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaskList  $taskList
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskList $taskList)
    {
        //
    }
}
