@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 49%;">
                            {{ __('Users') }}
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
                                                            @if (session()->has('fails') && session()->has('mes'))
                                                                <strong>

                                                                    {{ session()->get('mes')[0] }}:</strong>
                                                            @else
                                                                <strong style="overflow: hidden; max-height: 18px ">
                                                                    {{ session()->get('th') }}</strong>
                                                            @endif
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
                                            <th>Code</th>
                                            <th>FullName</th>
                                            <th>UserName</th>
                                            <th>Position</th>
                                            <th>Status</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->cde }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->position }}</td>
                                                <td>{{ $user->status }}</td>
                                                <td>
                                                    <div style="display: inline-block;">
                                                        <!-- Button trigger modalEditUser -->
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalEditUser{{ $user->cde }}">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                    </div>
                                                    {{-- <div style="display: inline-block;">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary black"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalflag{{ $user->cde }}">
                                                            <i class="material-icons">flag</i>
                                                        </button>
                                                    </div> --}}
                                                    <div style="display: inline-block;">
                                                        <!-- Button trigger modal -->
                                                        <a href="/home/users/{{ $user->cde }}"
                                                            class="btn btn-primary blue">
                                                            <i class="material-icons">arrow_forward</i>
                                                        </a>
                                                    </div>
                                                    <!-- Modal Edit User -->
                                                    <div class="modal fade" id="modalEditUser{{ $user->cde }}"
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
                                                                            Edit User</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        <div>
                                                                            <div class="box1">
                                                                                <div class="form-floating mb-3">
                                                                                    <input type="text"
                                                                                        class="form-control" name="cde"
                                                                                        placeholder="cde" id="cde"
                                                                                        value="{{ $user->cde }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">Code</label>
                                                                                </div>
                                                                                @error('cde')
                                                                                    <p class="alert alert-danger w-100"
                                                                                        role="alert">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                                <div class="form-floating mb-3 ">
                                                                                    <input type="text"
                                                                                        class="form-control" name="name"
                                                                                        placeholder="name" id="name"
                                                                                        value="{{ $user->name }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">FullName</label>
                                                                                </div>
                                                                                @error('name')
                                                                                    <p class="alert alert-danger w-100"
                                                                                        role="alert">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                                <div class="form-floating mb-3 ">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="username"
                                                                                        placeholder="username"
                                                                                        id="username"
                                                                                        value="{{ $user->username }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">UserName</label>
                                                                                </div>
                                                                                @error('username')
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
                                                                                        name="email" placeholder="email"
                                                                                        id="email"
                                                                                        value="{{ $user->email }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">Email</label>
                                                                                </div>
                                                                                @error('email')
                                                                                    <p class="alert alert-danger w-100"
                                                                                        role="alert">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                                <div class="form-floating mb-3 ">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="position"
                                                                                        placeholder="position"
                                                                                        id="position"
                                                                                        value="{{ $user->position }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">Position</label>
                                                                                </div>
                                                                                @error('position')
                                                                                    <p class="alert alert-danger w-100"
                                                                                        role="alert">
                                                                                        {{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                                <div class="form-floating mb-3 ">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="status"
                                                                                        placeholder="status"
                                                                                        id="status"
                                                                                        value="{{ $user->status }}">
                                                                                    <label class="fw-bold"
                                                                                        for="floatingInput">Status</label>
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
                                                    </div><!-- End Modal Edit User -->

                                                    <!-- Modal BlackList -->
                                                    {{-- <div class="modal fade" id="modalflag{{ $computer->SerialNumber }}"
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
                                                                                ({{ $computer->SerialNumber }})
                                                                                is already
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
                                                    </div><!-- End Modal BlackList --> --}}

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
