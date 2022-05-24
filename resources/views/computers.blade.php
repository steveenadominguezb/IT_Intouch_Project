@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline-block fw-bold" style="width: 49%;">
                        {{ __('Computers') }}
                    </div>


                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="" method="POST">
                        @csrf
                        <div style="height: 700px; overflow: scroll;">
                            @if (session()->has('message'))
                            <div class="alert alert-{{session()->get('alert')}}" role="alert">
                                {{session()->get('message')}}
                            </div>
                            @endif
                            <table style="margin-left: 10%; width: 80%">
                                <thead>
                                    <tr>
                                        <th>SerialNumber</th>
                                        <th>WorkStation</th>
                                        <th>Status</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($computers as $computer)
                                    <tr>
                                        <td>{{ $computer->SerialNumber }}</td>
                                        <td>{{ $computer->HostName }}</td>
                                        <td>{{ $computer->Status }}</td>
                                        <td>
                                            <div style="display: inline-block;">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal{{ $computer->SerialNumber }}">
                                                    <i class="material-icons">edit</i>
                                                </button>

                                            </div>
                                            <div style="display: inline-block;">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary red" data-bs-toggle="modal" data-bs-target="#modal{{ $computer->SerialNumber }}">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal{{ $computer->SerialNumber }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background: none; box-shadow: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form enctype="multipart/form-data" class="" method="POST" action="">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Edit Computer</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div>
                                                                    <div class="box1">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="text" class="form-control" name="serial" placeholder="nameWave" id="serial" value="{{$computer->SerialNumber}}">
                                                                            <label class="fw-bold" for="floatingInput">SerialNumber</label>
                                                                        </div>
                                                                        @error('serial')
                                                                        <p class="alert alert-danger w-100" role="alert">
                                                                            {{ $message }}
                                                                        </p>
                                                                        @enderror
                                                                        <div class="form-floating mb-3 ">
                                                                            <input type="text" class="form-control" name="host" placeholder="host" id="host" value="{{$computer->HostName}}">
                                                                            <label class="fw-bold" for="floatingInput">HostName</label>
                                                                        </div>
                                                                        @error('host')
                                                                        <p class="alert alert-danger w-100" role="alert">
                                                                            {{ $message }}
                                                                        </p>
                                                                        @enderror
                                                                        <div class="form-floating mb-3 ">
                                                                            <input type="text" class="form-control" name="os" placeholder="os" id="os" value="{{$computer->OS}}">
                                                                            <label class="fw-bold" for="floatingInput">OS</label>
                                                                        </div>
                                                                        @error('os')
                                                                        <p class="alert alert-danger w-100" role="alert">
                                                                            {{ $message }}
                                                                        </p>
                                                                        @enderror

                                                                    </div>

                                                                    <div class="box2">
                                                                        <div class="form-floating mb-3 ">
                                                                            <input type="text" class="form-control" name="brand" placeholder="brand" id="brand" value="{{$computer->Brand}}">
                                                                            <label class="fw-bold" for="floatingInput">Brand</label>
                                                                        </div>
                                                                        @error('brand')
                                                                        <p class="alert alert-danger w-100" role="alert">
                                                                            {{ $message }}
                                                                        </p>
                                                                        @enderror
                                                                        <div class="form-floating mb-3 ">
                                                                            <input type="text" class="form-control" name="model" placeholder="model" id="model" value="{{$computer->Model}}">
                                                                            <label class="fw-bold" for="floatingInput">Model</label>
                                                                        </div>
                                                                        @error('model')
                                                                        <p class="alert alert-danger w-100" role="alert">
                                                                            {{ $message }}
                                                                        </p>
                                                                        @enderror
                                                                        <div class="form-check" style="margin-top: 25px;">
                                                                            <label>
                                                                                <input type="checkbox" name="laptop" {{ ($computer->Laptop == 1 ? ' checked' : '')}} />
                                                                                <span class="fw-bold">Is a Laptop</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary grey" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary blue" style="margin-left: 20px;">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection