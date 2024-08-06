<?php

namespace Modules\User\Http\Controllers;

use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Task\Models\Task;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\SendInfoTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Modules\Task\Notifications\newTask;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $userTasks = UserTask::with(['task' => function ($query) {
            $query->with('subTasks');
        }])->where('user_id', $userId)->get();

        // die();

        // foreach ($userTasks as $task) {
        //     $subtasks = $task->task->subTasks;
        //     foreach ($subtasks as $subtask) {
        //         if ($subtask->children->count() > 0) {
        //             var_dump($subtask->children[0]->name);
        //         }
        //     }
        // }

        return view('user::index', compact('userTasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $userTask = UserTask::find($id);
        $userTask->is_done = $request->is_done;
        $userTask->save();

        session()->flash('success', 'Task berhasil diupdate');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
}
