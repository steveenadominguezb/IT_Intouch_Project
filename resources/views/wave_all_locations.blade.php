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
                        @foreach ($locations as $location)
                            <div>
                                {{ $location->Name }}
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
