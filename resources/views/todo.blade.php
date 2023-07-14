<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            overflow-x: hidden;
        }

        .weather-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: 1rem;
        }

        .filter-form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 1rem;
        }

        .footer {
            margin-top: 2rem;
            text-align: center;
            color: #fff;
            background-color: #F64C72;
            border-color: #F64C72;
        }
        .btn-custom {
            background-color: #F64C72;
            color: #fff;
        }
        .btn-primary {
            background-color: #2F2FA2;
            border-color: #2F2FA2;
            color: #fff;
        }
    </style>

    <title>My Crud</title>
</head>
<body>
    <div class="container mt-3">
        @if(isset($weather['weather']))
            <div class="weather-info">
                <div>
                    Current Weather: {{ $weather['weather'][0]['description'] }}
                </div>
                <div>
                    Temperature: {{ $weather['main']['temp'] }}°C
                </div>
            </div>
        @endif
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="text-center mt-5">
            <h2>Add Task</h2>

            <form class="row g-3 justify-content-center" method="POST" action="{{route('todos.store')}}">
                @csrf
                <div class="col-lg-4">
                <input type="text" class="form-control" name="name" placeholder="Name">
                </div>
                <div class="col-lg-4">
                <input type="text" class="form-control" name="task" placeholder="Task">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Submit</button>
                </div>
            </form>
        </div>

        <div class="text-center mt-5">
            <h2>Tasks</h2>

            <!-- Sorting -->
            <div class="text-center">
                <a href="{{ route('todos.index', ['sort_by' => 'name', 'sort_order' => 'asc']) }}" class="btn btn-custom">Sort by Name (Asc)</a>
                <a href="{{ route('todos.index', ['sort_by' => 'name', 'sort_order' => 'desc']) }}" class="btn btn-custom">Sort by Name (Desc)</a>
                <a href="{{ route('todos.index', ['sort_by' => 'task', 'sort_order' => 'asc']) }}" class="btn btn-custom">Sort by Tasks (Asc)</a>
                <a href="{{ route('todos.index', ['sort_by' => 'task', 'sort_order' => 'desc']) }}" class="btn btn-custom">Sort by Tasks (Desc)</a>
                <a href="{{ route('todos.index', ['sort_by' => 'created_at', 'sort_order' => 'asc']) }}" class="btn btn-custom">Sort by Created At (Asc)</a>
                <a href="{{ route('todos.index', ['sort_by' => 'created_at', 'sort_order' => 'desc']) }}" class="btn btn-custom">Sort by Created At (Desc)</a>
            </div>

            <!-- Filtering -->
            <form class="filter-form" action="{{ route('todos.index') }}" method="GET">
                <input type="text" class="form-control me-2" name="filter_name" placeholder="Name">
                <input type="text" class="form-control me-2" name="filter_task" placeholder="Task">
                <input type="date" class="form-control me-2" name="filter_created_at" placeholder="Created At">
                <select class="form-control me-2" name="filter_status">
                    <option value="">All</option>
                    <option value="0">Incomplete</option>
                    <option value="1">Completed</option>
                </select>
                <button class="btn btn-primary" type="submit">Filter</button>
            </form>


            <!-- Display todos -->
            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Task</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $counter=1 @endphp
                    @foreach($todos as $todo)
                        <tr>
                            <th>{{$counter}}</th>
                            <td>{{$todo->name}}</td>
                            <td>{{$todo->task}}</td>
                            <td>{{$todo->created_at}}</td>
                            <td>
                                @if($todo->is_completed)
                                    <div class="badge bg-success">Completed</div>
                                @else
                                    <div class="badge bg-warning">Not Completed</div>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('todos.edit',['todo'=>$todo->id])}}" class="btn btn-info">Edit</a>
                                <a href="{{route('todos.destroy',['todo'=>$todo->id])}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @php $counter++; @endphp
                    @endforeach
                </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $todos->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $todos->previousPageUrl() }}" aria-label="Previous" style="background-color: #2F2FA2; border-color: #2F2FA2; color: #fff;">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        @for ($i = 1; $i <= $todos->lastPage(); $i++)
                            <li class="page-item {{ $todos->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $todos->url($i) }}" style="{{ $todos->currentPage() == $i ? 'background-color: #2F2FA2; border-color: #2F2FA2; color: #fff;' : '' }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ $todos->currentPage() == $todos->lastPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $todos->nextPageUrl() }}" aria-label="Next" style="background-color: #2F2FA2; border-color: #2F2FA2; color: #fff;">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
<!-- Your existing code -->

    <!-- Footer -->
    <div class="footer">
        Made with Love <3 NFTmetaman
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
