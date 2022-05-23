@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline-block fw-bold" style="width: 50%;">
                        {{ $wave->programs->Name }}
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
                                <input type="text" class="form-control" style="margin-left: 10px;" name="floatingName" placeholder="nameWave" value="{{ $wave->Name}}" required>
                                <label for="floatingInput">Name Wave</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" style="margin-left: 10px;" name="floatingDate" value="{{ $wave->StartDate}}" required>
                                <label for="floatingInputGrid">Start Date</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" style="margin-left: 10px;" name="floatingInspector" placeholder="Itops Inspector" value="{{ $wave->ItopsInspector}}" required>
                                <label for="floatingInput">Itops Inspector</label>
                            </div>
                        </div>
                        <div style="width: 50%; float: left; margin-top: 10%;">
                            <a href="{{ url('/home/wave/' . $wave->IdWave . '/computers') }}" class="waves-effect waves-light btn">Assign Computers</a>
                            <a href="{{ url('/home/wave/' . $wave->IdWave . '/users') }}" class="waves-effect waves-light btn">Assign Users</a>

                        </div>
                    </div>
                </div>
            </div>
            @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
            <div class="card">

                <div class="card-body" style="height: max-content">

                    <div style=" width: 48%; display: inline-block; margin-left: 20px;">
                        @if ($computers_view)
                        <table>
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
                                        <div class="form-check">
                                            <label>
                                                <input type="checkbox" name="assign[]" value="{{$computer->SerialNumber}}" />
                                                <span class="fw-bold"></span>
                                            </label>
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
                    <div style=" width: 48%; display: inline-block;margin-left: 20px;">
                        @if ($users_view)
                        <table>
                            <thead>
                                <tr>
                                    <th>CODE</th>
                                    <th>Full Name</th>
                                    <th>Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users_view as $user)
                                <tr>
                                    <td>{{ $user->cde }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->position }}</td>
                                    <td>
                                        <div class="form-check">
                                            <label>
                                                <input type="checkbox" name="assign[]" value="{{$user->cde}}" />
                                                <span class="fw-bold"></span>
                                            </label>
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