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
                        <div style="text-align: center; margin-bottom: 30px;">
                            <form action="">
                                <div style="width: 40%; display: inline-block;margin-right: 20px;">
                                    <input type="text" name="text">
                                </div>
                                <div class="" style="display: inline-block;">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                        <form action="" method="POST">
                            @csrf
                            <div style="height: 700px; overflow: auto;">
                                @if (session()->has('message'))
                                    <div class="alert alert-{{ session()->get('alert') }}" role="alert">
                                        {{ session()->get('message') }}
                                        @if (session()->has('th'))
                                            <div class="accordion" id="accordionExample" style="background-color: none;">

                                                <div class="accordion-item" style="border-color: black;">
                                                    <h2 class="accordion-header" id="headingThree"
                                                        style=" background-color: none; margin-top: 0px;">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                            aria-expanded="false" aria-controls="collapseThree">
                                                            See more about the error
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse"
                                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <strong> {{ session()->get('th') }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal{{ $computer->SerialNumber }}">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                    </div>
                                                    <div style="display: inline-block;">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary black"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalflag{{ $computer->SerialNumber }}">
                                                            <i class="material-icons">flag</i>
                                                        </button>
                                                    </div>
                                                    <div style="display: inline-block;">
                                                        <!-- Button trigger modal -->
                                                        <a href="/computers/{{ $computer->SerialNumber }}"
                                                            class="btn btn-primary blue">
                                                            <i class="material-icons">arrow_forward</i>
                                                        </a>
                                                    </div>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modal{{ $computer->SerialNumber }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="staticBackdropLabel" aria-hidden="true"
                                                        style="background: none; box-shadow: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form enctype="multipart/form-data" class=""
                                                                    method="POST" action="">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="staticBackdropLabel">
                                                                            Edit Computer</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        <div>
                                                                            <div class="box1">
                                                                                <div class="form-floating mb-3">
                                                                                    <input type="text"
                                                                                        class="form-control" name="serial"
                                                                                        placeholder="nameWave"
                                                                                        id="serial"
                                                                                        value="{{ $computer->SerialNumber }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">SerialNumber</label>
                                                                                </div>
                                                                                @error('serial')
                                                                                    <p class="alert alert-danger w-100"
                                                                                        role="alert">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                                <div class="form-floating mb-3 ">
                                                                                    <input type="text"
                                                                                        class="form-control" name="host"
                                                                                        placeholder="host" id="host"
                                                                                        value="{{ $computer->HostName }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">HostName</label>
                                                                                </div>
                                                                                @error('host')
                                                                                    <p class="alert alert-danger w-100"
                                                                                        role="alert">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                                <div class="form-floating mb-3 ">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="os" placeholder="os"
                                                                                        id="os"
                                                                                        value="{{ $computer->OS }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">OS</label>
                                                                                </div>
                                                                                @error('os')
                                                                                    <p class="alert alert-danger w-100"
                                                                                        role="alert">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                                <div class="form-floating mb-3 ">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="status" placeholder="status"
                                                                                        id="status"
                                                                                        value="{{ $computer->Status }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">Status</label>
                                                                                </div>
                                                                                @error('status')
                                                                                    <p class="alert alert-danger w-100"
                                                                                        role="alert">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="box2">
                                                                                <div class="form-floating mb-3 ">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="brand" placeholder="brand"
                                                                                        id="brand"
                                                                                        value="{{ $computer->Brand }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">Brand</label>
                                                                                </div>
                                                                                @error('brand')
                                                                                    <p class="alert alert-danger w-100"
                                                                                        role="alert">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                                <div class="form-floating mb-3 ">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="model" placeholder="model"
                                                                                        id="model"
                                                                                        value="{{ $computer->Model }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">Model</label>
                                                                                </div>
                                                                                @error('model')
                                                                                    <p class="alert alert-danger w-100"
                                                                                        role="alert">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                                <div class="form-check"
                                                                                    style="margin-top: 50px;">
                                                                                    <label>
                                                                                        <input type="checkbox"
                                                                                            name="laptop"
                                                                                            {{ $computer->Laptop == 1 ? ' checked' : '' }} />
                                                                                        <span class="fw-bold">Is a
                                                                                            Laptop</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary grey"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary blue"
                                                                            style="margin-left: 20px;">Save</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="modalflag{{ $computer->SerialNumber }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="staticBackdropLabel" aria-hidden="true"
                                                        style="background: none; box-shadow: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form enctype="multipart/form-data" class=""
                                                                    method="get" action="">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title fw-bold"
                                                                            id="staticBackdropLabel">BLACK LIST</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @if ($computer->Status != 'InBlackList')
                                                                            <strong>Would you like to add this
                                                                                computer({{ $computer->SerialNumber }}) to
                                                                                the blacklist?</strong>
                                                                        @else
                                                                            <strong>This computer
                                                                                ({{ $computer->SerialNumber }}) is already
                                                                                blacklisted, would you like to change
                                                                                it?</strong>
                                                                        @endif

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary grey"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <a href="/computers/blacklist/{{ $computer->SerialNumber }}"
                                                                            class="btn btn-primary blue">
                                                                            YES
                                                                        </a>
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
