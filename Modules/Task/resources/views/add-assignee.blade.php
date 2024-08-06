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

</head>

<style>
    html,
    body {
        height: 100%;
        margin: 0px;
        padding: 0px;
    }
</style>

<body>
    <!-- Modal -->
    <div class="modal fade" id="penerimaModal" tabindex="-1" aria-labelledby="penerimaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="penerimaModalLabel">Penerima</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/add-assignee/{{ $task->id }}" method="post">
                        @csrf
                        <select class="form-control" name="assignee">
                            @foreach ($assignee as $a )
                            <option value="{{ $a->id }}">{{ $a->name }} - {{ $a->email }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary mt-4 w-100" type="submit">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container w-75" style="margin-top: 50px;">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h3>Penerima Tugas</h3>
                <a style="text-decoration: none;" href="/task"><span>Task</span></a> / <span>Penerima</span>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#penerimaModal">
                <i class="fas fa-plus"></i> Penerima
            </button>
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

        <div class="pt-4">
            <table class="table table-hover table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Nama</td>
                        <td>{{ $task->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Deskripsi</td>
                        <td>{{ $task->description }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Dibuat</td>
                        <td>{{ $task->created_at }} </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Penerima</td>
                        <td>
                            <ul>
                                @foreach ($userTask as $u )
                                <li>{{ $u->user->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- js bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>



@endsection