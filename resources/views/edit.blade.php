<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>

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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 520px;
            background: #ffffff;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 10px 14px;
            font-size: 0.95rem;
            color: #1e293b;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus,
        select:focus {
            background-color: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
        }

        button {
            flex: 1;
            background-color: #2563eb;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 600;
            border: none;
            padding: 11px 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        .btn-cancel {
            display: inline-block;
            text-align: center;
            text-decoration: none;
            color: #64748b;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 11px 18px;
            border-radius: 8px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .btn-cancel:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .error-alert {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .error-alert p {
            color: #dc2626;
            font-size: 0.875rem;
            line-height: 1.4;
        }

        .error-alert p + p {
            margin-top: 4px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Edit Task</h1>

    @if($errors->any())
        <div class="error-alert">
            @foreach($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="task_name">Task Name</label>
            <input type="text" id="task_name" name="task_name" value="{{ $task->task_name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4">{{ $task->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" id="due_date" name="due_date" value="{{ $task->due_date }}">
        </div>

        <div class="actions">
            <button type="submit">Update Task</button>
            <a href="{{ route('tasks.index') }}" class="btn-cancel">Cancel</a>
        </div>

    </form>

</div>

</body>
</html>