@extends('layout')

@section('title', 'Edit Task')

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Task</h1>

        @include('tasks._form', [
            'action' => route('tasks.update', $task),
            'method' => 'PUT',
            'task' => $task
        ])
    </div>
@endsection
