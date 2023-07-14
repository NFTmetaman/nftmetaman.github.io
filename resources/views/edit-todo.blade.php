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
        .footer {
            margin-top: 2rem;
            text-align: center;
            color: #fff;
            background-color: #F64C72;
            border-color: #F64C72;
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
            <h2>Edit Task</h2>
        </div>

        <form method="POST" action="{{route('todos.update',['todo'=>$todo->id])}}">
            @csrf
            {{ method_field('PUT') }}

            <div class="row justify-content-center mt-5">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{$todo->name}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Task</label>
                        <input type="text" class="form-control" name="task" placeholder="Task" value="{{$todo->task}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_completed" id="" class="form-control">
                            <option value="1" @if($todo->is_completed==1) selected @endif>Complete</option>
                            <option value="0" @if($todo->is_completed==0) selected @endif>Not Complete</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
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
