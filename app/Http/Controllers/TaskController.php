<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\TaskController\Task;
use Illuminate\Http\Request;
use App\Models\Task; // Ditambahkan

class TaskController extends Controller
{
    private $tasks;

    public function __construct()
    {
    }

  public function index()
  {
    $pageTitle = 'Task List';
    $tasks = Task::all(); // Diperbarui
    return view('tasks.index', [
      'pageTitle' => $pageTitle,
      'tasks' => $tasks,
    ]);
  }

  public function edit($id)
  {
    $pageTitle = 'Edit Task';
    $task = Task::find($id); // Diperbarui

//    $task = $tasks[$id - 1];

    return view('tasks.edit', ['pageTitle' => $pageTitle, 'task' => $task]);
  }

  public function create()
  {
    $pageTitle = 'Create Task';
    $tasks = $this->tasks;

    return view('tasks.create', ['pageTitle' => $pageTitle, 'task' => $tasks]);
  }

  // Tambahkan method store()
  public function store(Request $request)
  {

    // Code untuk proses validasi
    $request->validate(
      [
        'name' => 'required',
        'due_date' => 'required',
        'status' => 'required',
      ],
      $request->all()
    );

    Task::create([
      'name' => $request->name,
      'detail' => $request->detail,
      'due_date' => $request->due_date,
      'status' => $request->status,
    ]);

    return redirect()->route('tasks.index');
  }

  public function update(Request $request, $id)
  {
    $task = Task::find($id);
    $task->update([
      // data task yang berasal dari formulir
      $task->name = $request->name,
      $task->detail = $request->detail,
      $task->due_date = $request->due_date,
      $task->status = $request->status,
    ]);

    // Code untuk melakukan redirect menuju GET /tasks
    return redirect()->route('tasks.index');
  }

  public function delete($id)
  {
    // Menyebutkan judul dari halaman yaitu "Delete Task"
    $pageTitle = 'Delete Task';
    //  Memperoleh data task menggunakan $id
    $task = Task::find($id);
    // Menghasilkan nilai return berupa file view dengan halaman dan data task di atas
    return view('tasks.delete', ['pageTitle' => $pageTitle, 'task' => $task]);
  }

  public function destroy($id)
  {
    $task = Task::find($id);
//    $task = // Memperoleh task tertentu menggunakan $id
    $task->delete();
    // Melakukan redirect menuju tasks.index
    return redirect()->route('tasks.index');
  }

  public function progress()
  {
    $title = 'Task Progress';

    $allTasks = Task::all();

    $filteredTasks = $allTasks->groupBy('status');

    $tasks = [
      Task::STATUS_NOT_STARTED => $filteredTasks->get(
        Task::STATUS_NOT_STARTED, []
      ),
      Task::STATUS_IN_PROGRESS => $filteredTasks->get(
        Task::STATUS_IN_PROGRESS, []
      ),
      Task::STATUS_IN_REVIEW => $filteredTasks->get(
        Task::STATUS_IN_REVIEW, []
      ),
      Task::STATUS_COMPLETED => $filteredTasks->get(
        Task::STATUS_COMPLETED, []
      ),
    ];

//    @include('partials.task_column',
//    [
//      'title' => 'Not Started',
//      'tasks' => $tasks['not_started'],
//      'leftStatus' => null,
//      'rightStatus' => 'in_progress',
//    ])

    return view('tasks.progress', [
      'pageTitle' => $title,
      'tasks' => $tasks,
    ]);
}
}
