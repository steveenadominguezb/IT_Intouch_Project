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

                <div class="card-body" style="height: 100%;">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div style="margin-left: 5%;">
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
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Assign Computers</button>
                            <button type="button" class="btn btn-primary">Assign Users</button>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection