<!DOCTYPE html>
<html>
<head>
    <title>Personal Task Manager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .add-button {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #f1f5f9;
        }

        .pending {
            color: #b45309;
            font-weight: bold;
        }

        .completed {
            color: #15803d;
            font-weight: bold;
        }

        .button {
            border: none;
            padding: 7px 10px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .edit {
            background: #2563eb;
        }

        .delete {
            background: #dc2626;
        }

        .status {
            background: #16a34a;
        }

        form {
            display: inline;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Personal Task Manager</h1>

    <a href="{{ route('tasks.create') }}" class="add-button">
        + Add New Task
    </a>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($tasks->count() > 0)

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($tasks as $task)

                    <tr>

                        <td>{{ $task->id }}</td>

                        <td>{{ $task->task_name }}</td>

                        <td>{{ $task->description }}</td>

                        <td>
                            @if($task->status == 'Completed')
                                <span class="completed">
                                    Completed
                                </span>
                            @else
                                <span class="pending">
                                    Pending
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $task->due_date ?? 'No deadline' }}
                        </td>

                        <td>

                            <a href="{{ route('tasks.edit', $task->id) }}"
                               class="button edit">
                                Edit
                            </a>

                            <form action="{{ route('tasks.destroy', $task->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="button delete"
                                        onclick="return confirm('Delete this task?')">
                                    Delete
                                </button>

                            </form>

                            <form action="{{ route('tasks.status', $task->id) }}"
                                  method="POST">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="button status">
                                    @if($task->status == 'Pending')
                                        Complete
                                    @else
                                        Pending
                                    @endif
                                </button>

                            </form>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @else

        <p>No tasks found. Add your first task!</p>

    @endif

</div>

</body>
</html>