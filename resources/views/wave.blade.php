@extends('layouts.app')

@section('content')
    <div class="wave" style="width: 70%; margin: auto">
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
                                    @if (isset($all_locations))
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
                            <div style="width: 35%; float: left; margin-right: 15%;display: inline-block">
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


            </div>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-{{ session()->get('alert') }}" role="alert" style="width: 65%; margin: auto;">
            {{ session()->get('message') }}
            @if (session()->has('th'))
                <div class="accordion" id="accordionExample" style="background-color: none;">

                    <div class="accordion-item" style="border-color: black;">
                        <h2 class="accordion-header" id="headingThree" style=" background-color: none; margin-top: 0px;">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <strong style="overflow: hidden; max-height: 18px "> {{ session()->get('th') }}</strong>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong> {{ session()->get('th') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
    <div>

        @yield('assign')
    </div>
    <!-- Add location modal -->
    <div class="modal fade" style="background: none; box-shadow: none;" id="modal_add_location" data-bs-backdrop="static"
        data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btn_register" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
