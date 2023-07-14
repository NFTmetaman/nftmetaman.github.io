<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $query = Todo::query();

    // Sorting
    $sortBy = $request->input('sort_by');
    $sortOrder = $request->input('sort_order', 'asc');
    if ($sortBy) {
        $query->orderBy($sortBy, $sortOrder);
    }

    // Filtering
    $filterName = $request->input('filter_name');
    $filterTask = $request->input('filter_task');
    $filterCreatedAt = $request->input('filter_created_at');
    $filterStatus = $request->input('filter_status');
    if ($filterName) {
        $query->where('name', 'like', '%' . $filterName . '%');
    }
    if ($filterTask) {
        $query->where('task', 'like', '%' . $filterTask . '%');
    }
    if ($filterCreatedAt) {
        $query->whereDate('created_at', $filterCreatedAt);
    }
    if ($filterStatus) {
        $query->where('is_completed', $filterStatus);
    }

    // Pagination
    $todos = $query->paginate(5);

    return view('todo', compact('todos'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'task' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect()->route('todos.index')->withErrors($validator);
    }

    Todo::create([
        'name' => $request->input('name'),
        'task' => $request->input('task'),
    ]);

    return redirect()->route('todos.index')->with('success', 'Inserted');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $todo=Todo::where('id',$id)->first();
        return view('edit-todo',compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'task' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->route('todos.edit',['todo'=>$id])->withErrors($validator);
        }



        $todo=Todo::where('id',$id)->first();
        $todo->name=$request->get('name');
        $todo->task=$request->get('task');
        $todo->is_completed=$request->get('is_completed');
        $todo->save();

        return redirect()->route('todos.index')->with('success', 'Updated Todo');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Todo::where('id',$id)->delete();
        return redirect()->route('todos.index')->with('success', 'Deleted Todo');
    }
}