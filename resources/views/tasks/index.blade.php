@extends('layout')

@section('title', 'Tasks')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-4">
            <h1 class="text-3xl font-bold text-gray-800">Tasks</h1>

            <select id="project-filter" class="border rounded px-2 py-1 text-sm">
                <option value="">All Projects</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" @if(request()->query('project') == $project->id) selected @endif>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
            Add Task
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div id="tasks-container" class="space-y-2">
        @foreach($tasks as $task)
            <div class="task-item bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow cursor-move"
                 data-id="{{ $task->id }}" data-priority="{{ $task->priority }}">
                <div class="flex justify-between items-center">
                    <div class="flex-1">
                        <h3 class="font-semibold text-lg">{{ $task->title }}</h3>
                        <div class="flex items-center space-x-4 mt-2">
                            <span class="text-sm text-gray-600">Project: {{ $task->project->name }}</span>
                            <span class="task-priority text-sm px-2 py-1 bg-yellow-100 text-yellow-800 rounded">
                                Priority: {{ $task->priority }}
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500 hover:text-blue-700">
                            Edit
                        </a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filter = document.getElementById('project-filter');
            if (filter) {
                filter.addEventListener('change', function () {
                    const val = this.value;
                    const base = '{{ route("tasks.index") }}';
                    if (!val) {
                        window.location.href = base;
                    } else {
                        window.location.href = base + '?project=' + encodeURIComponent(val);
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('tasks-container');
            const sortable = Sortable.create(container, {
                animation: 150,
                ghostClass: 'opacity-50',
                onEnd: function (evt) {
                    const taskItems = Array.from(container.querySelectorAll('.task-item'));
                    const taskIds = taskItems.map(item => item.dataset.id);

                    fetch('{{ route("tasks.reorder") }}', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            task_ids: taskIds
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                return response.text().then(text => {
                                    console.error('Server returned non-OK response:', response.status, text);
                                    throw new Error('Server error');
                                });
                            }
                            const ct = response.headers.get('content-type') || '';
                            if (ct.indexOf('application/json') === -1) {
                                return response.text().then(text => {
                                    console.error('Expected JSON but got:', text);
                                    throw new Error('Invalid JSON response');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data && data.success) {
                                const items = Array.from(container.querySelectorAll('.task-item'));
                                if (data.priorities) {
                                    items.forEach(item => {
                                        const id = item.dataset.id;
                                        const newPriority = data.priorities[id];
                                        item.dataset.priority = newPriority;
                                        const span = item.querySelector('.task-priority');
                                        if (span) span.textContent = 'Priority: ' + newPriority;
                                    });
                                } else {
                                    const total = items.length;
                                    items.forEach((item, idx) => {
                                        const newPriority = total - idx;
                                        item.dataset.priority = newPriority;
                                        const span = item.querySelector('.task-priority');
                                        if (span) span.textContent = 'Priority: ' + newPriority;
                                    });
                                }
                                console.log('Tasks reordered successfully');
                            }
                        })
                        .catch(error => {
                            console.error('Error reordering tasks:', error);
                        });
                }
            });
        });
    </script>
@endsection
