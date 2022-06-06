@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 20%;">
                            <a href="{{ url('/home/wave/' . $wave->IdWave . '') }}"
                                style="color: black;">{{ $wave->programs->Name }}</a>
                        </div>
                        <div style="display: inline-block; text-align: end; width: 79%;">
                            <a href="{{ url('/home/wave/' . $wave->IdWave . '/computers') }}"
                                class="btn-flat fw-bold border-start border-3"
                                style="font-size: 12px"
                                >Assign Computers</a>
                            <a href="{{ url('/home/wave/' . $wave->IdWave . '/users') }}"
                                class="btn-flat fw-bold border-start border-end border-3"
                                style="font-size: 12px"
                                >Assign Users</a>
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
                                        placeholder="nameWave" value="{{ $wave->Name }}" required>
                                    <label for="floatingInput">Name Wave</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" style="margin-left: 10px;" name="floatingDate"
                                        value="{{ $wave->StartDate }}" required>
                                    <label for="floatingInputGrid">Start Date</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" style="margin-left: 10px;"
                                        name="floatingInspector" placeholder="Itops Inspector"
                                        value="{{ $wave->ItopsInspector }}" required>
                                    <label for="floatingInput">Itops Inspector</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div>
        @yield('assign')
    </div>
@endsection
