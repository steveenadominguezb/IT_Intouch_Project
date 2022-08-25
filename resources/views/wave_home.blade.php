@extends('layouts.app')

@section('content')
    <div class="wave_home" style="width: 70%; margin: auto">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 40%;">
                            <a href="{{ url('/home/wave/' . $wave->IdWave . '/' . $wave->location->IdLocation . '') }}"
                                style="color: black;">{{ $wave->parent->programs->Name }} -</a>

                            <div class="dropdown" style="display: inline-block;">
                                <button class="dropdown-toggle fw-bold" type="button" id="btn-all-locations"
                                    style="background: none; border: none" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (session()->has('all_locations'))
                                        {{ $all_locations }}
                                    @else
                                        {{ $wave->location->Name }}
                                    @endif
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    @foreach ($locations as $location)
                                        <li><a class="dropdown-item"
                                                href="/home/wave/{{ $wave->IdWave }}/{{ $location->location->IdLocation }}">{{ $location->location->Name }}</a>
                                        </li>
                                    @endforeach
                                    <li><a class="dropdown-item" href="/wave/{{ $wave->IdWave }}/all-locations">All
                                            Locations</a>
                                    </li>
                                    <li>
                                        <!-- Button trigger add location modal -->
                                        <button type="button" class="btn-flat" data-bs-toggle="modal"
                                            data-bs-target="#modal_add_location">
                                            Add Location
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="content-wave-options" id="btn-all-locations">
                            <a href="/home/wave/{{ $wave->IdWave }}/{{ $wave->location->IdLocation }}/computers"
                                class="btn-flat fw-bold border-start border-3">Assign Computers</a>
                            <a href="/home/wave/{{ $wave->IdWave }}/{{ $wave->location->IdLocation }}/users"
                                class="btn-flat fw-bold border-start border-end border-3">Assign
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
                            <div style="width: 35%; float: left; margin-right: 15%; display: inline-block">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" style="margin-left: 10px;"
                                        name="floatingName" placeholder="nameWave" value="{{ $wave->parent->Name }}"
                                        required>
                                    <label for="floatingInput">Name Wave</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" style="margin-left: 10px;"
                                        name="floatingDate" value="{{ $wave->parent->StartDate }}" required>
                                    <label for="floatingInputGrid">Start Date</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" style="margin-left: 10px;"
                                        name="floatingInspector" placeholder="Itops Inspector"
                                        value="{{ $wave->parent->ItopsInspector }}" required>
                                    <label for="floatingInput">Itops Inspector</label>
                                </div>
                            </div>
                            <div id="wave_progress" style="display: inline-block; width: 40%">
                                <div class="progress grey">
                                    @if ($progress == 100)
                                        {
                                        <div class="determinate green" style="width: {{ $progress }}%"></div>
                                        }
                                    @else
                                        <div class="determinate yellow" style="width: {{ $progress }}%"></div>
                                    @endif
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
                                            @if (session()->has('fails') && session()->has('mes'))
                                                <strong>

                                                    {{ session()->get('mes')[0] }}
                                                    ({{ session()->get('fails') }}):</strong>
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
                <div class="card" style="max-height: 700px; overflow: auto;">
                    <div style="margin-right: 2%; margin-top: 2%; text-align: end">
                        <!-- Button trigger modal RELATE EVERYTHING -->
                        <button type="button" class="btn btn-small btn-primary grey fw-bold" style=""
                            data-bs-toggle="modal" data-bs-target="#modal_relate_everything">Relate everything
                        </button>
                    </div>
                    <!-- Modal RELATE EVERYTHING -->
                    <div class="modal fade" id="modal_relate_everything" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
                        style="background: none; box-shadow: none;">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form enctype="multipart/form-data" class="" method="POST" action="">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">
                                            Relate
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <div style="display: inline-block">
                                            <input type="file" name="file">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary grey"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" id="btn_register" class="btn btn-primary blue"
                                            style="margin-left: 20px;"
                                            onclick="style ='margin-left: 20px;cursor: not-allowed; pointer-events: none;'">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- End Modal RELATE EVERYTHING -->

                    <div class="card-body " style="display: table; overflow: scroll; margin-left: 2%; margin-right: 1%">
                        {{-- Computers Frame --}}
                        <div class="border-end" style=" width: 35%; display: table-cell; ">
                            <div>
                                <div style="display: inline-block;">
                                    <h6 class="fw-bold">Computers ({{ sizeof($computers_view) }})</h6>

                                </div>
                                <div style="display: inline-block; text-align: right; width: 70%;">

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
                                                                    action="/assign/{{ $wave->IdWave }}/{{ $wave->location->IdLocation }}/{{ $computer->SerialNumber }}">
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

                                                                        <div>
                                                                            <strong
                                                                                style="margin-left: 2%; font-size: 15px">
                                                                                {{ $computer->name }}</strong>
                                                                        </div>
                                                                        <div class="form-floating mb-3">
                                                                            <input type="text" class="form-control"
                                                                                style="margin-left: 10px;" name="UserCode"
                                                                                placeholder="nameWave"
                                                                                value="{{ $computer->cde }}" required>
                                                                            <label for="floatingInput">User Code</label>
                                                                        </div>
                                                                        @if ($wave->parent->programs->Name == 'Airbnb')
                                                                            <div class="form-floating mb-3">
                                                                                <input type="text" class="form-control"
                                                                                    style="margin-left: 10px;"
                                                                                    name="yubikey" placeholder="nameWave"
                                                                                    value="{{ $computer->SerialNumberKey }}" required>
                                                                                <label for="floatingInput">Yubikey</label>
                                                                            </div>
                                                                        @endif


                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary grey"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary blue"
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
                                                                    action="/home/wave/{{ $wave->IdWave }}/{{ $wave->location->IdLocation }}/computer/{{ $computer->SerialNumber }}">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <h6>unassign the computer
                                                                            {{ $computer->SerialNumber }} ?</h6>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary grey"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary blue"
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

                        </div>{{-- End Computers Frame --}}

                        {{-- Users --}}
                        <div class="border-start" style=" width: 45%; display: table-cell; padding-left: 1%">
                            <div>
                                <div style="display: inline-block;">
                                    <h6 class="fw-bold">Users ({{ sizeof($users_view) }})</h6>

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
                                                    {{-- <div style="display: inline-block;">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary green">
                                                            <i class="material-icons">compare_arrows</i>
                                                        </button>
                                                    </div> --}}
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
                                                                    action="/home/wave/{{ $wave->IdWave }}/{{ $wave->location->IdLocation }}/user/{{ $user->cde }}">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <h6>unassign the user {{ $user->cde }} ?</h6>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary grey"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary blue"
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
                        </div> {{-- End div users --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Add location modal -->
    <div class="modal fade" style="background: none; box-shadow: none;" id="modal_add_location"
        data-bs-backdrop="static" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/home/wave/{{ $wave->IdWave }}/{{ $wave->IdWaveLocation }}/new-location" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <select class="form-select" name="floatingSelectLocation"
                                aria-label="Floating label select example" required>
                                <option value="101">Bogotá</option>
                                <option value="201">Medellín</option>
                                <option value="301">Bucaramanga</option>
                                <option value="401">Barranquilla</option>
                                <option value="501">Cali</option>

                            </select>
                            <label for="floatingSelect">Select Location</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn blue">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Inventory update modal -->
    <div class="modal fade" style="background: none; box-shadow: none;" id="modal_inventory_update"
        data-bs-backdrop="static" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inventory Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/home/wave/{{ $wave->IdWave }}/{{ $wave->IdWaveLocation }}/new-location" method="POST">
                    @csrf
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-3 grey" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary blue">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
