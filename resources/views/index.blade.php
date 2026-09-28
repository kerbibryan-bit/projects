<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Task Manager</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            padding: 40px 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: #ffffff;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
        }

        .add-button {
            display: inline-flex;
            align-items: center;
            background-color: #2563eb;
            color: #ffffff;
            padding: 10px 18px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.2s ease;
        }

        .add-button:hover {
            background-color: #1d4ed8;
        }

        .alert-success {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            text-align: left;
        }

        th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px 16px;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.925rem;
            color: #334155;
            vertical-align: middle;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
            text-transform: capitalize;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-completed {
            background-color: #d1fae5;
            color: #065f46;
        }

        /* Action Buttons Layout */
        .actions-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn {
            display: inline-block;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.825rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background-color: #f1f5f9;
            color: #2563eb;
        }

        .btn-edit:hover {
            background-color: #dbeafe;
        }

        .btn-delete {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .btn-delete:hover {
            background-color: #fee2e2;
        }

        .btn-status {
            background-color: #f0fdf4;
            color: #16a34a;
        }

        .btn-status:hover {
            background-color: #dcfce7;
        }

        form {
            display: inline;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #64748b;
            font-size: 0.95rem;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header-bar">
        <h1>Personal Task Manager</h1>
        <a href="{{ route('tasks.create') }}" class="add-button">
            + Add New Task
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($tasks->count() > 0)
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Task</th>
                        <th>Description</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 130px;">Due Date</th>
                        <th style="width: 220px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td><strong>#{{ $task->id }}</strong></td>
                            <td style="font-weight: 600; color: #0f172a;">{{ $task->task_name }}</td>
                            <td>{{ $task->description ?? '—' }}</td>
                            <td>
                                @if($task->status == 'Completed')
                                    <span class="badge badge-completed">Completed</span>
                                @else
                                    <span class="badge badge-pending">Pending</span>
                                @endif
                            </td>
                            <td>{{ $task->due_date ? date('M d, Y', strtotime($task->due_date)) : 'No deadline' }}</td>
                            <td>
                                <div class="actions-group">
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this task?')">
                                            Delete
                                        </button>
                                    </form>

                                    <form action="{{ route('tasks.status', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-status">
                                            {{ $task->status == 'Pending' ? 'Complete' : 'Pending' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p>No tasks found. Click <strong>+ Add New Task</strong> to create your first task!</p>
        </div>
    @endif

</div>

</body>
</html>