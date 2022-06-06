@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 40%;">
                            <a href="{{ url('/home/wave/' . $wave->IdWave . '/' . $wave->locations->IdLocation . '') }}"
                                style="color: black;">{{ $wave->parent->programs->Name }} -</a>

                            <div class="dropdown" style="display: inline-block;">
                                <button class="dropdown-toggle fw-bold" type="button" id="dropdownMenuButton1"
                                    style="background: none; border: none" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $wave->locations->Name }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    @foreach ($locations as $location)
                                        <li><a class="dropdown-item"
                                                href="/home/wave/{{ $wave->IdWave }}/{{ $location->locations->IdLocation }}">{{ $location->locations->Name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div style="display: inline-block; text-align: end; width: 59%;">
                            <a href="/home/wave/{{ $wave->IdWave }}/{{ $wave->locations->IdLocation }}/computers"
                                class="btn-flat fw-bold border-start border-3" style="font-size: 12px">Assign Computers</a>
                            <a href="/home/wave/{{ $wave->IdWave }}/{{ $wave->locations->IdLocation }}/users"
                                class="btn-flat fw-bold border-start border-end border-3" style="font-size: 12px">Assign
                                Users</a>
                        </div>
                    </div>

                    <div class="card-body" style="height: max-content">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div style="margin-left: 5%; width: 100%; height: max-content">
                            <div style="width: 35%; float: left; margin-right: 15%;">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" style="margin-left: 10px;" name="floatingName"
                                        placeholder="nameWave" value="{{ $wave->parent->Name }}" required>
                                    <label for="floatingInput">Name Wave</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" style="margin-left: 10px;" name="floatingDate"
                                        value="{{ $wave->parent->StartDate }}" required>
                                    <label for="floatingInputGrid">Start Date</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" style="margin-left: 10px;"
                                        name="floatingInspector" placeholder="Itops Inspector"
                                        value="{{ $wave->parent->ItopsInspector }}" required>
                                    <label for="floatingInput">Itops Inspector</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @if (session()->has('message'))
                    <div class="alert alert-{{ session()->get('alert') }}" role="alert">
                        {{ session()->get('message') }}
                        @if (session()->has('th'))
                            <div class="accordion" id="accordionExample" style="background-color: none;">

                                <div class="accordion-item" style="border-color: black;">
                                    <h2 class="accordion-header" id="headingThree"
                                        style=" background-color: none; margin-top: 0px;">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Accordion Item #3
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
                <div class="card" style="max-height: 700px; overflow: auto;">

                    <div class="card-body " style="display: table;border-spacing: 40px; overflow: scroll;">

                        <div class="border-end" style=" width: 40%; display: table-cell; ">
                            <div>
                                <div style="display: inline-block;">
                                    <h6 class="fw-bold">Computers</h6>

                                </div>
                                <div style="display: inline-block; text-align: right; width: 80%;">

                                    <input type="text" style="display: inline-block; width: 50%;">
                                    <button type="button" class="btn btn-primary blue">
                                        <i class="material-icons">search</i>
                                    </button>
                                </div>
                            </div>
                            @if (sizeof($computers_view) != 0)
                                <table style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th>SerialNumber</th>
                                            <th>WorkStation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($computers_view as $computer)
                                            <tr>
                                                <td>{{ $computer->SerialNumber }}</td>
                                                <td>{{ $computer->HostName }}</td>
                                                <td>
                                                    <div class="form-check" style="display: inline-block;">
                                                        <label>
                                                            @if ($computer->cde == null)
                                                                <input type="checkbox" name="assign[]"
                                                                    value="{{ $computer->SerialNumber }}" disabled />
                                                            @else
                                                                <input type="checkbox" name="assign[]"
                                                                    value="{{ $computer->SerialNumber }}" checked
                                                                    disabled />
                                                            @endif
                                                            <span class="fw-bold"></span>
                                                        </label>
                                                    </div>
                                                    <div style="display: inline-block;">
                                                        <!-- Button trigger modal 2 -->
                                                        <button type="button" class="btn btn-primary green"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal2{{ $computer->SerialNumber }}">
                                                            <i class="material-icons">compare_arrows</i>
                                                        </button>
                                                    </div>
                                                    <!-- Modal 2 -->
                                                    <div class="modal fade" id="modal2{{ $computer->SerialNumber }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="staticBackdropLabel" aria-hidden="true"
                                                        style="background: none; box-shadow: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <form enctype="multipart/form-data" class=""
                                                                    method="POST"
                                                                    action="/assign/{{ $wave->IdWave }}/{{ $computer->SerialNumber }}">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="staticBackdropLabel">
                                                                            Assign User to {{ $computer->SerialNumber }}
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="text" class="form-control"
                                                                                style="margin-left: 10px;" name="UserCode"
                                                                                placeholder="nameWave"
                                                                                value="{{ $computer->cde }}" required>
                                                                            <label for="floatingInput">User Code</label>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary grey"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary blue"
                                                                            style="margin-left: 20px;">YES</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="display: inline-block;">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary red"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal{{ $computer->SerialNumber }}">
                                                            <i class="material-icons">clear</i>
                                                        </button>
                                                    </div>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modal{{ $computer->SerialNumber }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="staticBackdropLabel" aria-hidden="true"
                                                        style="background: none; box-shadow: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <form enctype="multipart/form-data" class=""
                                                                    method="POST"
                                                                    action="/home/wave/{{ $wave->IdWave }}/computer/{{ $computer->SerialNumber }}">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <h6>unassign the computer
                                                                            {{ $computer->SerialNumber }} ?</h6>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary grey"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary blue"
                                                                            style="margin-left: 20px;">YES</button>
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
                            @else
                                no data found
                            @endif

                        </div>
                        <div class="border-end" style=" width: 50%; display: table-cell;margin-left: 10px;">
                            <div>
                                <div style="display: inline-block;">
                                    <h6 class="fw-bold">Users</h6>

                                </div>
                                <div style="display: inline-block; text-align: right; width: 80%;">

                                    <input type="text" style="display: inline-block; width: 50%;">
                                    <button type="button" class="btn btn-primary blue">
                                        <i class="material-icons">search</i>
                                    </button>
                                </div>
                            </div>
                            @if (sizeof($users_view) != 0)
                                <table style="font-size: 12px;">

                                    <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>Full Name</th>
                                            <th>User Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users_view as $user)
                                            <tr>
                                                <td>{{ $user->cde }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>
                                                    <div class="form-check" style="display: inline-block;">
                                                        <label>
                                                            @if ($user->SerialNumberComputer == null)
                                                                <input type="checkbox" name="assign[]"
                                                                    value="{{ $user->cde }}" disabled />
                                                            @else
                                                                <input type="checkbox" name="assign[]"
                                                                    value="{{ $user->cde }}" checked disabled />
                                                            @endif

                                                            <span class="fw-bold"></span>
                                                        </label>
                                                    </div>
                                                    <div style="display: inline-block;">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary green">
                                                            <i class="material-icons">compare_arrows</i>
                                                        </button>
                                                    </div>
                                                    <div style="display: inline-block;">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary red"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal{{ $user->cde }}">
                                                            <i class="material-icons">clear</i>
                                                        </button>
                                                    </div>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modal{{ $user->cde }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="staticBackdropLabel" aria-hidden="true"
                                                        style="background: none; box-shadow: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <form enctype="multipart/form-data" class=""
                                                                    method="POST"
                                                                    action="/home/wave/{{ $wave->IdWave }}/user/{{ $user->cde }}">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <h6>unassign the user {{ $user->cde }} ?</h6>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary grey"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary blue"
                                                                            style="margin-left: 20px;">YES</button>
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
                            @else
                                no data found
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
