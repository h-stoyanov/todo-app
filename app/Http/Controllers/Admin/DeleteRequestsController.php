<?php

namespace App\Http\Controllers\Admin;

use App\TaskList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteRequestsController extends Controller
{
    public function index()
    {
        $lists = TaskList::where('delete_request', true)->get();
        return view('admin.delete-requests', ['lists' => $lists]);
    }

    public function destroy($id)
    {
        $taskList = TaskList::where([
            ['id', '=', $id],
            ['delete_request', '=', true]
        ])->first();

        if ($taskList->delete()){
            return response()->json(['message' => 'Successfully deleted list']);
        }
        return response()->json(['message' => 'Cannot delete list'], 400);
    }
}
