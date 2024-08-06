@extends('task::layouts.master')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Task</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awsomr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    {{-- Modal Logout --}}
    <div class="modal fade" id="logoutModal" aria-labelledby="logoutModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="logoutModal"> Konfirmasi </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <span>Anda Ingin Logout?</span>
                        <div class="mt-2 mb-4 d-flex justify-content-center" style="gap: 8px">
                            <div>
                                <a href="/logout" class="btn btn-danger">YA</a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">TIDAK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container w-50" style="padding-top: 50px">
        <div class="w-100 d-flex justify-content-between align-items-center">
            <h2>Hi, {{ Auth::user()->name }}</h2>
            <div>
                <button type="button" class="btn mx-2 btn-sm btn-danger" data-bs-toggle="modal"
                    data-bs-target="#logoutModal" data-parent-id="0">
                    <i class="fa-solid fa-arrow-right-from-bracket" style="transform: rotate(3.142rad);"></i>
                    Logout
                </button>
            </div>
        </div>

        <div>
            @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @elseif(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
            @elseif(session('delete'))
            <div class="alert alert-danger mt-3">
                {{ session('delete') }}
            </div>
            @endif
        </div>

        @if(!$userTasks->isEmpty())
        @foreach($userTasks as $userTask)
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex">
                        <form action="{{ route('user-task.update', $userTask->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-check d-flex align-items-center" style="gap:8px">
                                <input type="hidden" name="is_done" value="{{ $userTask->is_done ? '1' : '0' }}">
                                <input class="form-check-input" style="font-size:15px" type="checkbox"
                                    id="task-checkbox-{{ $userTask->id }}" {{ $userTask->is_done ? 'checked' : '' }}
                                onchange="updateStatus(this, '{{ $userTask->id }}')">
                                <h5 style="margin:0px" class="card-title">{{ $userTask->task->name }}</h5>
                            </div>
                        </form>
                    </div>
                    @if($userTask->task->children->isNotEmpty())
                    <button class="mx-2 btn btn-sm btn-light text-danger" type="button" data-toggle="collapse"
                        data-target="#task-{{ $userTask->task->id }}" aria-expanded="false"
                        aria-controls="task-{{ $userTask->task->id }}">
                        <i class="fas fa-angle-down"></i>
                    </button>
                    @endif
                </div>
                @if($userTask->task->children->isNotEmpty())
                <div class="collapse" id="task-{{ $userTask->task->id }}">
                    <ul class="list-group mt-3">
                        @foreach($userTask->task->children as $subTask)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <h6>{{ $subTask->name }}</h6>
                                @if($subTask->children->isNotEmpty())
                                <button class="btn btn-sm btn-light text-danger float-right" type="button"
                                    data-toggle="collapse" data-target="#subtask-{{ $subTask->id }}"
                                    aria-expanded="false" aria-controls="subtask-{{ $subTask->id }}">
                                    <i class="fas fa-angle-down"></i>
                                </button>
                                @endif
                            </div>
                            @if($subTask->children->isNotEmpty())
                            <div class="collapse" id="subtask-{{ $subTask->id }}">
                                <ul class="list-group mt-2">
                                    @foreach($subTask->children as $child)
                                    <li class="list-group-item">{{ $child->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
        <!-- @endforeach -->
        @else
        <div class="alert alert-warning mt-3">
            Tidak ada tugas yang ditemukan
        </div>
        @endif


    </div>

    {{-- update status --}}
    <script>
        function updateStatus(checkbox, taskId) {
            var form = checkbox.closest('form');
            var hiddenInput = form.querySelector('input[name="is_done"]');
            // nilai input hidden
            hiddenInput.value = checkbox.checked ? '1' : '0';
            form.submit();
        }
    </script>

    <!-- js bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>



@endsection