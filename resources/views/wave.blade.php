@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 40%;">
                            <a href="{{ url('/home/wave/' . $wave->IdWave . '/' . $wave->location->IdLocation . '') }}"
                                style="color: black;">{{ $wave->parent->programs->Name }} -</a>

                            <div class="dropdown" style="display: inline-block;">
                                <button class="dropdown-toggle fw-bold" type="button" id="dropdownMenuButton1"
                                    style="background: none; border: none" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $wave->location->Name }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    @foreach ($locations as $location)
                                        <li><a class="dropdown-item"
                                                href="/home/wave/{{ $wave->IdWave }}/{{ $location->location->IdLocation }}">{{ $location->location->Name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div style="display: inline-block; text-align: end; width: 59%;">
                            <a href="/home/wave/{{ $wave->IdWave }}/{{ $wave->location->IdLocation }}/computers"
                                class="btn-flat fw-bold border-start border-3" style="font-size: 12px">Assign Computers</a>
                            <a href="/home/wave/{{ $wave->IdWave }}/{{ $wave->location->IdLocation }}/users"
                                class="btn-flat fw-bold border-start border-end border-3" style="font-size: 12px">Assign
                                Users</a>
                            <a href="/home/wave/{{ $wave->IdWave }}/{{ $wave->location->IdLocation }}/inventory"
                                class="btn-flat fw-bold border-end border-3" style="font-size: 12px">
                                Inventory Update</a>
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
                                Accordion Item #3
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
@endsection
