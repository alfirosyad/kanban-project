<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\TaskController\Task;
use Illuminate\Http\Request;
use App\Models\Task; // Ditambahkan
use Illuminate\Support\Facades\Auth; // Ditambahkan


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

  public function home()
  {
    $tasks = Task::where('user_id', auth()->id())->get();

    $completed_count = $tasks
      ->where('status', Task::STATUS_COMPLETED)
      ->count();

    $uncompleted_count = $tasks
      ->whereNotIn('status', Task::STATUS_COMPLETED)
      ->count();

    return view('home', [
      'completed_count' => $completed_count,
      'uncompleted_count' => $uncompleted_count,
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
      'user_id' => Auth::user()->id, // Ditambahkan
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

    return view('tasks.progress', [
      'pageTitle' => $title,
      'tasks' => $tasks,
    ]);
  }

  public function move(int $id, Request $request)
  {
    $task = Task::findOrFail($id);

    $task->update([
      'status' => $request->status,
    ]);

    return redirect()->route('tasks.progress');
  }

  // Fungsi untuk mengubah status card menjadi Completed
  public function completed(Request $request, $id)
  {
    $task = Task::findOrFail($id);
    $task->status = 'Completed';
    $task->save();

    return redirect()->route('tasks.progress');
  }
}
