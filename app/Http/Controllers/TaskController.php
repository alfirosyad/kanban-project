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
}
