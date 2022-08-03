@extends('wave')
@section('assign')
    <div class="wave" style="width: 70%; margin: auto">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card" style="max-height: 700px; overflow: auto;">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 49%;">
                            {{ __('All Locations') }}
                        </div>
                    </div>
                    <div class="card-body " style="display: table;border-spacing: 40px; overflow: scroll;">
                        <table style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Users</th>
                                    <th>Computers</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $location)
                                    <tr>
                                        <td>{{ $location->Name }} ({{ sizeof($location->Users) }})</td>
                                        <td>
                                            @foreach ($location->Users as $user)
                                                {{ $user->name }}
                                                <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($location->Computers as $computer)
                                                {{ $computer->HostName }}
                                                <br>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
