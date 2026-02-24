<form action="{{ $action }}" method="POST">
    @csrf
    @if(isset($method) && strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div class="mb-4">
        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
        <input type="text"
               id="title"
               name="title"
               value="{{ old('title', ($task->title ?? '')) }}"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
               required>
        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
        <label for="project_id" class="block text-gray-700 text-sm font-bold mb-2">Project</label>
        <select id="project_id"
                name="project_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                required>
            <option value="">Select a project</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}"
                    {{ (string)old('project_id', ($task->project_id ?? '')) === (string)$project->id ? 'selected' : '' }}>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
        @error('project_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-6">
        <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">Priority</label>
        <input type="number"
               id="priority"
               name="priority"
               value="{{ old('priority', ($task->priority ?? 0)) }}"
               min="0"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
               required>
        @error('priority') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex space-x-4">
        <button type="submit"
                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
            {{ strtoupper(isset($method) && $method !== 'POST' ? 'Update Task' : 'Create Task') }}
        </button>
        <a href="{{ route('tasks.index') }}"
           class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg text-center">
            Cancel
        </a>
    </div>
</form>

