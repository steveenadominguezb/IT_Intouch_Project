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
                        <div style="margin-left: 5%">
                            <div style="margin-bottom: 3%; margin-right: 3%; display: inline-block">
                                <h6>Computer Information</h6>
                                <div style="display: table; font-size: 15px">
                                    <p style="display: table-cell; border-right: 20px solid transparent">
                                        <label>WorkStation:</label>
                                        {{ $computer->HostName }}
                                    </p>
                                    <p style="display: table-cell; border-right: 20px solid transparent">
                                        <label>Serial:</label>
                                        {{ $computer->SerialNumber }}
                                    </p>
                                    <p style="display: table-cell; border-right: 20px solid transparent">
                                        <label>Status:</label>
                                        {{ $computer->Status }}
                                    </p>
                                </div>
                            </div>
                            <div style="margin-bottom: 3%; display: inline-block">
                                <h6>End User</h6>
                                <div style="display: table; font-size: 15px">
                                    <p style="display: table-cell; border-right: 20px solid transparent">
                                        <label>Code:</label>
                                        {{ $waves_computer[0]->user->cde ?? '' }}
                                    </p>
                                    <p style="display: table-cell; border-right: 20px solid transparent">
                                        <label>Name:</label>
                                        {{ $waves_computer[0]->user->name ?? '' }}
                                    </p>
                                    <p style="display: table-cell; border-right: 20px solid transparent">
                                        <label>UserName:</label>
                                        {{ $waves_computer[0]->user->username ?? '' }}
                                    </p>
                                </div>

                            </div>
                            <div>
                                <h6>Waves History Information</h6>
                                @foreach ($waves_computer as $wave)
                                    <div style="display: table; font-size: 15px;">
                                        <p style="display: table-cell; width: 200px">
                                            <label>Program:</label>
                                            {{ $wave->parent->parent->programs->Name }}
                                        </p>
                                        <p style="display: table-cell; width: 150px">
                                            <label>Location:</label>
                                            {{ $wave->parent->location->Name }}
                                        </p>
                                        <p style="display: table-cell; width: 230px">
                                            <label>Wave:</label>
                                            {{ $wave->parent->parent->Name }}
                                        </p>
                                        <p style="display: table-cell; width: 150px">
                                            @if ($wave->attrition == 0)
                                                <label>
                                                    <input name="group{{ $wave->parent->parent->Name }}" class="blue" type="radio" checked/>
                                                    <span>.</span>
                                                </label>
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
