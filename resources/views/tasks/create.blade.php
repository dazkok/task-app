@extends('layout')

@section('title', 'Create Task')

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Task</h1>

        @include('tasks._form', [
            'action' => route('tasks.store'),
            'method' => 'POST',
            'task' => null
        ])
    </div>
@endsection
