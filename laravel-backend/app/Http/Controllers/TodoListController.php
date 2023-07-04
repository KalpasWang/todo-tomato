<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = TodoList::all();
        return response($lists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $list = TodoList::create($request->all());
        return response($list, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TodoList $todoList)
    {
        return response($todoList);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TodoList $todoList)
    {
        $todoList->update($request->all());
        return response($todoList);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TodoList $todoList)
    {
        //
    }
}
