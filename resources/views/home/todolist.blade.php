<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-3">
        <form method="post" action="/logout">
            @csrf
            <button class="btn btn-lg btn-danger" type="submit">Sign Out</button>
        </form>
    </div>

    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 mb-3">Todolist</h1>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form class="p-4 p-md-5 border rounded-3 bg-light" method="post" action="{{ route('todolist.store') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="task" placeholder="Enter a new todo">
                    <label for="task">Todo</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Add Todo</button>
            </form>
        </div>
    </div>

    <div class="row align-items-right g-lg-5 py-5">
        <div class="mx-auto">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Todo</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($todos as $index => $todo)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $todo->task }}</td>
                        <td>
                            @if ($todo->completed)
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <form method="post" action="{{ route('todolist.destroy', $todo->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Remove</button>
                            </form>

                            @if (!$todo->completed)
                                <form method="post" action="{{ route('todolist.complete', $todo->id) }}" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success btn-sm" type="submit">Mark as Done</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
