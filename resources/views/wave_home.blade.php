@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline-block fw-bold" style="width: 50%;">
                        <a href="{{ url('/home/wave/' . $wave->IdWave . '') }}" style="color: black;">{{ $wave->programs->Name }}</a>
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
                            <a href="{{ url('/home/wave/' . $wave->IdWave . '/computers') }}" class="ms-5 waves-effect waves-light btn">Assign Computers</a>
                            <a href="{{ url('/home/wave/' . $wave->IdWave . '/users') }}" class="ms-5 waves-effect waves-light btn">Assign Users</a>

                        </div>
                    </div>
                </div>
            </div>
            @if (session()->has('message'))
            <div class="alert alert-{{session()->get('alert')}}" role="alert">
                {{session()->get('message')}}
            </div>
            @endif
            <div class="card" style="max-height: 700px; overflow: auto;">

                <div class="card-body" style="display: table;border-spacing: 40px; overflow: scroll;">

                    <div style=" width: 48%; display: table-cell; ">
                        <h6 class="fw-bold" style="text-align: center;">Computers</h6>
                        @if (sizeof($computers_view)!=0)
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
                                        <div class="form-check" style="display: inline-block;">
                                            <label>
                                                <input type="checkbox" name="assign[]" value="{{$computer->SerialNumber}}" />
                                                <span class="fw-bold"></span>
                                            </label>
                                        </div>
                                        <div style="display: inline-block;">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary red" data-bs-toggle="modal" data-bs-target="#modal{{ $computer->SerialNumber }}">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modal{{ $computer->SerialNumber }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background: none; box-shadow: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form enctype="multipart/form-data" class="" method="POST" action="/home/wave/{{$wave->IdWave}}/computer/{{$computer->SerialNumber}}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <h6>unassign the computer {{$computer->SerialNumber}} ?</h6>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary grey" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary blue" style="margin-left: 20px;">YES</button>
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
                    <div style=" width: 48%; display: table-cell;margin-left: 30px;">
                        <h6 class="fw-bold" style="text-align: center;">Users</h6>
                        @if (sizeof($users_view)!=0)
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
                                        <div class="form-check" style="display: inline-block;">
                                            <label>
                                                <input type="checkbox" name="assign[]" value="{{$user->cde}}" />
                                                <span class="fw-bold"></span>
                                            </label>
                                        </div>
                                        <div style="display: inline-block;">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary red" data-bs-toggle="modal" data-bs-target="#modal{{ $user->cde }}">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modal{{ $user->cde }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background: none; box-shadow: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form enctype="multipart/form-data" class="" method="POST" action="/home/wave/{{$wave->IdWave}}/user/{{$user->cde}}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <h6>unassign the user {{$user->cde}} ?</h6>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary grey" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary blue" style="margin-left: 20px;">YES</button>
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