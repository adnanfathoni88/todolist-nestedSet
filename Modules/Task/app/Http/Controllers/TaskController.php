<?php

namespace Modules\Task\Http\Controllers;

use App\Models\UserTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Task\Jobs\Newtask;
use Modules\Task\Models\Task;
use App\Models\User as ModelsUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Modules\Task\Emails\SendEmailTask;
use Modules\Task\Notifications\NotifyTask;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('children', 'subTasks')->defaultOrder()->get();
        $taskDone = UserTask::with('user', 'task')->where('is_done', 1)->get();
        // dd($taskUser);
        return view('task::index', compact('tasks', 'taskDone'));
    }

    public function create()
    {
    }

    public function store(Request $request, $parentId)
    {
        $data = $request->validate(
            [
                'name' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Task harus diisi',
                'name.max' => 'Task name must not be greater than 255 characters',
            ]
        );

        $parentId = Task::find($parentId);

        if (!$parentId) {
            // root
            $data['level'] = 0;
            $node = Task::create($data);
            $node->saveAsRoot();
            session()->flash('success', 'Task berhasil ditambahkan');
            return redirect()->route('task.index');
        } else {
            // child
            $data['level'] = $parentId->level + 1;
            $data['parent_id'] = $parentId->id;
            $task = new Task($data);
            $parentId->prependNode($task);
            session()->flash('success', 'Task berhasil ditambahkan sebagai subtask');
            return redirect()->route('task.index');
        }
    }


    public function update(Request $request, $id): RedirectResponse
    {
        // dd($request->all());
        $data = $request->validate(
            [
                'name' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Task harus diisi',
                'name.max' => 'Task name must not be greater than 255 characters',
            ]
        );

        $task = Task::find($id);
        $data['parent_id'] = $task->parent_id;
        $task->update($data);
        session()->flash('success', 'Task berhasil diupdate');
        return redirect()->route('task.index');
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        session()->flash('delete', 'Task berhasil dihapus');
        return redirect()->route('task.index');
    }

    public function addAssignee($id)
    {
        // dapatkan user yang beum terassign di task ini
        $task = Task::find($id);
        $userTask = UserTask::where('task_id', $id)->pluck('user_id');
        $assignee = User::whereNotIn('id', $userTask)->get();

        // user yang terlibat
        $userTask = UserTask::with('user')->where('task_id', $id)->get();

        return view('task::add-assignee', compact('task', 'assignee', 'userTask'));
    }

    public function storeAssignee(Request $request, $id)
    {
        $data = $request->validate(
            [
                'assignee' => 'required',
            ],
            [
                'assignee.required' => 'User harus diisi',
            ]
        );
        $data['user_id'] = $data['assignee'];
        $data['task_id'] = $id;
        $data['updated_by'] = Auth::id();
        UserTask::create($data);

        // Notifikasi ke user, queue
        $user = User::find($data['user_id']); // Pastikan ini adalah objek User
        $task = Task::find($id)->name;
        $date = now()->format('Y-m-d H:i:s');

        if ($user) {
            Notification::send($user, new NotifyTask($task, $date));
            // simpan notif di dalam database

        } else {
            session()->flash('error', 'User tidak ditemukan.');
        }



        session()->flash('success', 'User berhasil diass ign ke task');
        return redirect()->route('task.add-assignee', $id);
    }

    public function sendEmail()
    {
        $user = Auth::user();
        $x = User::find(4);

        Notification::send($x, new NotifyTask());
    }
}
