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
                        <table style="border: none">
                            <tr>
                                <th>Code: {{ $user->cde }}</th>
                                <th>Name: {{ $user->name }}</th>
                                <th>Username: {{ $user->username }}</th>
                                <th>Position: {{ $user->position }}</th>
                                <th>Status: {{ $user->status }}</th>
                            </tr>
                            @foreach ($waves_user as $wave)
                                <tr>
                                    <td>Program: {{ $wave->parent->parent->programs->Name }}</td>
                                    <td>Location: {{ $wave->parent->location->Name }}</td>
                                    <td>Wave: {{ $wave->parent->parent->Name }}</td>
                                    <td>Date: {{ $wave->Date }}</td>
                                    @if (!isset($wave->computer->HostName))
                                        puto
                                    @endif
                                    <td>WorkStation:
                                        @if (isset($wave->computer->HostName))
                                            {{ $wave->computer->HostName }}
                                        @endif
                                    </td>
                                    <td>Serial:
                                        @if (isset($wave->computer->SerialNumber))
                                            {{ $wave->computer->SerialNumber }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
