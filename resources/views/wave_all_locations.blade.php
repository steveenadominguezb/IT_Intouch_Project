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
                        <div style="display: table; width: 100%">
                            @foreach ($result as $location)
                                <div style="display: table-cell; height: fit-content; ">
                                    <div style="display: table-caption;">
                                        {{ $location->Name }}
                                    </div>
                                    <div style="display: table-row-group">
                                        <div style="display: table-cell">
                                            Computers ({{ sizeof($location->Computers) }})
                                            @foreach ($location->Computers as $computer)
                                                <div>
                                                    <strong>{{ $computer->HostName }}</strong>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div style="display: table-cell">
                                            Users ({{ sizeof($location->Users) }})
                                            @foreach ($location->Users as $user)
                                                <div>
                                                    <strong>{{ $user->name }}</strong>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
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
