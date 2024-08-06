@extends('task::layouts.master')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hierarki Tugas</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awsomr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .task-level-0 {
            font-weight: bold;
        }

        .task-level-1 {
            padding-left: 30px;
        }

        .task-level-2 {
            padding-left: 60px;
        }

        .task-level-3 {
            padding-left: 90px;
        }

        .task-level-4 {
            padding-left: 120px;
        }
    </style>
</head>

<body>
    <div class="container w-75">
        {{-- modal selesai --}}
        <div class="modal fade" id="doneModal" aria-labelledby="doneModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="doneModal">Task Diselesaikan</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        @foreach ($taskDone as $t )
                        <div class="d-flex justify-content-between">
                            <span>- {{ $t->task->name }} / {{ $t->user->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


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

        <!-- Create Modal Task -->
        <div class="modal fade" id="todoModal" aria-labelledby="todoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="todoModalLabel">Form Tambah</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- input -->
                        <form id="add-task-form" method="POST">
                            @csrf
                            <label class="form-label">Masukan Task</label>
                            <input class="form-control form-lg" type="text" name="name" autofocus>
                            <button class="btn btn-primary mt-4 w-100" type="submit">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal Task -->
        <div class="modal fade" id="editModal" aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="editModal">Form Edit</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- input -->
                        <form id="edit-task-form" method="POST">
                            @csrf
                            @method('PUT')
                            <label class="form-label">Masukan Task</label>
                            <input class="form-control form-lg" type="text" name="name" autofocus>
                            <button class="btn btn-primary mt-4 w-100" type="submit">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal hapus --}}
        <div class="modal fade" id="hapusModal" aria-labelledby="hapusModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="hapusModal"> Konfirmasi </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <span>Ingin hapus data <b id="delete-name"></b>?</span>
                            <div class="mt-4 d-flex justify-content-center" style="gap: 8px">
                                <div>
                                    <form id="form-delete" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">YA</button>
                                    </form>
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

        <!-- task list -->
        <div class="p-4 mt-4">
            <div class="d-flex align-items-center justify-content-between">
                <h4>TODO LIST</h4>
                <div>
                    {{-- modal tugas selesai --}}
                    <button type="button" class="btn  btn-success" data-bs-toggle="modal" data-bs-target="#doneModal"
                        data-parent-id="0">
                        <i class="fa-solid fa-check"></i> Selesai
                    </button>
                    <button type="button" class="btn mx-1 btn-primary" data-bs-toggle="modal"
                        data-bs-target="#todoModal" data-parent-id="0">
                        <i class="fa-solid fa-plus"></i> Task
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal"
                        data-parent-id="0">
                        <i class="fa-solid fa-arrow-right-from-bracket" style="transform: rotate(3.142rad);"></i>
                        Logout
                    </button>
                </div>
            </div>

            {{-- notif session --}}
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

            <div class="container mt-4">
                @foreach($tasks as $task)
                <div class="card px-4 py-3 mb-1">
                    <div class="task-level-{{ $task->level }} d-flex justify-content-between mb-1 align-items-center">

                        {{-- tree --}}
                        <div>
                            {{ $task->name }}
                            @if($task->level < 2) <button type="button" class="btn btn-light text-primary"
                                data-bs-toggle="modal" data-bs-target="#todoModal" data-parent-id={{ $task->
                                id }}>
                                <i class="fa-solid fa-plus"></i>
                                </button>
                                @endif
                        </div>

                        {{-- button --}}
                        <div>

                            @if($task->level == 0)
                            <a href="/add-assignee/{{ $task->id }}" class="btn btn-light text-success"><i
                                    class="fa-solid fa-person"></i></a>
                            @endif
                            <button type="button" class="btn btn-light text-black"
                                onclick="handleEdit('{{ $task->id }}','{{ $task->name }}')">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-light text-danger"
                                onclick="handleDelete('{{ $task->id }}','{{ $task->name }}')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- js bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var todoModal = document.getElementById('todoModal');
            todoModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var parentId = button.getAttribute('data-parent-id');
                var form = document.getElementById('add-task-form');
                form.action = '/add-task/' + parentId;

            });
        })
    </script>
    <script>
        function handleEdit(id, name) {
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            var form = document.getElementById('edit-task-form');
            form.action = '/edit-task/' + id;
            form.name.value = name;
            editModal.show();

        }
    </script>

    <script>
        function handleDelete(id, name) {
            var hapusModal = new bootstrap.Modal(document.getElementById('hapusModal'));
            var deleteName = document.getElementById('delete-name');
            var formDelete = document.getElementById('form-delete');
            formDelete.action = '/delete-task/' + id;
            deleteName.innerHTML = name;
            hapusModal.show();
        }
    </script>
</body>

</html>



@endsection