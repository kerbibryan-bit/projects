<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            margin-left: 10px;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Edit Task</h1>

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <label>Task Name</label>

        <input type="text"
               name="task_name"
               value="{{ $task->task_name }}"
               required>

        <label>Description</label>

        <textarea name="description"
                  rows="5">{{ $task->description }}</textarea>

        <label>Status</label>

        <select name="status">

            <option value="Pending"
                {{ $task->status == 'Pending' ? 'selected' : '' }}>
                Pending
            </option>

            <option value="Completed"
                {{ $task->status == 'Completed' ? 'selected' : '' }}>
                Completed
            </option>

        </select>

        <label>Due Date</label>

        <input type="date"
               name="due_date"
               value="{{ $task->due_date }}">

        <button type="submit">
            Update Task
        </button>

        <a href="{{ route('tasks.index') }}">
            Cancel
        </a>

    </form>

</div>

</body>
</html>