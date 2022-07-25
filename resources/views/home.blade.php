@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-13">
                {{-- Dashboard --}}
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 49%;">
                            {{ __('Dashboard') }}
                        </div>
                        <div class="d-inline-block text-end" style="width: 49%;">
                            <button class="fw-bold fs-3 " style="border: none; background: none;" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">+</button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @foreach ($waves as $wave)
                            <div class="sizes">
                                <div class="card " style="height: 320px;">
                                    <div class=" card-image waves-effect waves-block waves-light small">
                                        <img class="activator" style="height: fit-content;"
                                            src="img/{{ $wave->programs->img }}" alt="program image">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title activator grey-text text-darken-4 fw-bold"
                                            style="font-size: 15px;">{{ $wave->programs->Name }}<i
                                                class="material-icons right">more_vert</i></span>
                                        <p class="card-text fw-bold">{{ $wave->Name }}</p>
                                        <p>{{ $wave->StartDate }}</p>
                                    </div>
                                    <div class="card-reveal">
                                        <div style="position: relative;">
                                            <div style="height: 48%;">
                                                <span class="card-title grey-text text-darken-4 fw-bold"
                                                    style="font-size: 15px;">{{ $wave->Name }}<i
                                                        class="material-icons right">close</i></span>
                                                @php
                                                    $waves_locations = \App\Models\WaveLocation::where('IdWave', $wave->IdWave)->get();
                                                    $computers = 0;
                                                    $users = 0;
                                                    foreach ($waves_locations as $value) {
                                                        $computers += \App\Models\WaveEmployee::where('IdWave', $value->IdWaveLocation)
                                                            ->where('SerialNumberComputer', 'LIKE', '%')
                                                            ->count();
                                                        $users += \App\Models\WaveEmployee::where('IdWave', $value->IdWaveLocation)
                                                            ->where('cde', 'LIKE', '%')
                                                            ->count();
                                                    }
                                                @endphp
                                                <br>
                                                <p style="font-size: 12px;">Assigned computers: {{ $computers }}</p>
                                                <p style="font-size: 12px;">Assigned users: {{ $users }}</p>
                                            </div>
                                            <div style="position: fixed; bottom: 0; margin-bottom: 10%;">
                                                <a href="{{ url('/home/wave/' . $wave->IdWave . '/101') }}"
                                                    class="waves-effect waves-light btn-small"><i
                                                        class="material-icons right">edit</i>edit</a>
                                                @if (Auth::user()->privilege == 10001)
                                                    <div style="display: inline-block">
                                                        <form action="/home/wave/delete" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="IdWave"
                                                                value="{{ $wave->IdWave }}">
                                                            <button type="submit" style="background: none; border: none"
                                                                class="waves-effect waves-light"><i
                                                                    class="material-icons right">delete</i></button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                {{-- Last Week --}}
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 30%;">
                            {{ __('Last Week') }}
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @foreach ($waves_last_week as $wave)
                            <div class="sizes">
                                <div class="card " style="height: 320px;">
                                    <div class=" card-image waves-effect waves-block waves-light small">
                                        <img class="activator" style="height: fit-content;"
                                            src="img/{{ $wave->programs->img }}" alt="program image">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title activator grey-text text-darken-4 fw-bold"
                                            style="font-size: 15px;">{{ $wave->programs->Name }}<i
                                                class="material-icons right">more_vert</i></span>
                                        <p class="card-text fw-bold">{{ $wave->Name }}</p>
                                        <p>{{ $wave->StartDate }}</p>
                                    </div>
                                    <div class="card-reveal">
                                        <div style="position: relative;">
                                            <div style="height: 48%;">
                                                <span class="card-title grey-text text-darken-4 fw-bold"
                                                    style="font-size: 15px;">{{ $wave->Name }}<i
                                                        class="material-icons right">close</i></span>
                                                @php
                                                    $waves_locations = \App\Models\WaveLocation::where('IdWave', $wave->IdWave)->get();
                                                    $computers = 0;
                                                    $users = 0;
                                                    foreach ($waves_locations as $value) {
                                                        $computers += \App\Models\WaveEmployee::where('IdWave', $value->IdWaveLocation)
                                                            ->where('SerialNumberComputer', 'LIKE', '%')
                                                            ->count();
                                                        $users += \App\Models\WaveEmployee::where('IdWave', $value->IdWaveLocation)
                                                            ->where('cde', 'LIKE', '%')
                                                            ->count();
                                                    }
                                                @endphp
                                                <br>
                                                <p style="font-size: 12px;">Assigned computers: {{ $computers }}</p>
                                                <p style="font-size: 12px;">Assigned users: {{ $users }}</p>
                                            </div>
                                            <div style="position: fixed; bottom: 0; margin-bottom: 10%;">
                                                <a href="{{ url('/home/wave/' . $wave->IdWave . '/101') }}"
                                                    class="waves-effect waves-light btn-small"><i
                                                        class="material-icons right">edit</i>edit</a>
                                                @if (Auth::user()->privilege == 10001)
                                                    <div style="display: inline-block">

                                                        <button type="submit" style="background: none; border: none"
                                                            class="waves-effect waves-light" data-bs-toggle="modal"
                                                            data-bs-target="#DeleteWaveModal"><i
                                                                class="material-icons right">delete</i></button>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                {{-- Search Wave --}}
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 30%;">
                            {{ __('Search Wave') }}
                        </div>
                        <div style="text-align: center; display: inline-block; width: 60%;">
                            <form action="">
                                <div style="width: 60%; display: inline-block;margin-right: 20px;">
                                    <input type="text" name="text">
                                </div>
                                <div class="" style="display: inline-block;">
                                    <button type="submit" class="btn btn-primary small">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body" style="height: 700px; overflow: scroll;">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @foreach ($search_wave as $wave)
                            <div class="sizes">
                                <div class="card " style="height: 320px;">
                                    <div class=" card-image waves-effect waves-block waves-light small">
                                        <img class="activator" style="height: fit-content;"
                                            src="img/{{ $wave->programs->img }}" alt="program image">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title activator grey-text text-darken-4 fw-bold"
                                            style="font-size: 15px;">{{ $wave->programs->Name }}<i
                                                class="material-icons right">more_vert</i></span>
                                        <p class="card-text fw-bold">{{ $wave->Name }}</p>
                                        <p>{{ $wave->StartDate }}</p>
                                    </div>
                                    <div class="card-reveal">
                                        <div style="position: relative;">
                                            <div style="height: 48%;">
                                                <span class="card-title grey-text text-darken-4 fw-bold"
                                                    style="font-size: 15px;">{{ $wave->Name }}<i
                                                        class="material-icons right">close</i></span>
                                                @php
                                                    $waves_locations = \App\Models\WaveLocation::where('IdWave', $wave->IdWave)->get();
                                                    $computers = 0;
                                                    $users = 0;
                                                    foreach ($waves_locations as $value) {
                                                        $computers += \App\Models\WaveEmployee::where('IdWave', $value->IdWaveLocation)
                                                            ->where('SerialNumberComputer', 'LIKE', '%')
                                                            ->count();
                                                        $users += \App\Models\WaveEmployee::where('IdWave', $value->IdWaveLocation)
                                                            ->where('cde', 'LIKE', '%')
                                                            ->count();
                                                    }
                                                @endphp
                                                <br>
                                                <p style="font-size: 12px;">Assigned computers: {{ $computers }}</p>
                                                <p style="font-size: 12px;">Assigned users: {{ $users }}</p>
                                            </div>
                                            <div style="position: fixed; bottom: 0; margin-bottom: 10%;">
                                                <a href="{{ url('/home/wave/' . $wave->IdWave . '/101') }}"
                                                    class="waves-effect waves-light btn-small"><i
                                                        class="material-icons right">edit</i>edit</a>
                                                @if (Auth::user()->privilege == 10001)
                                                    <div style="display: inline-block">
                                                        <form action="/home/wave/delete" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="IdWave"
                                                                value="{{ $wave->IdWave }}">
                                                            <button type="submit" style="background: none; border: none"
                                                                class="waves-effect waves-light"><i
                                                                    class="material-icons right">delete</i></button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" style="background: none; box-shadow: none; width: 600px"
        data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Wave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('wave.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <select class="form-select" name="floatingSelect" aria-label="Floating label select example"
                                required>
                                <option selected>Open this select menu</option>
                                <option value="101">TCP</option>
                                <option value="102">GNC</option>
                                <option value="103">Optavia</option>
                                <option value="104">Airbnb</option>
                                <option value="105">Booking</option>
                                <option value="106">L'Oreal</option>
                                <option value="107">Walmart Spark</option>
                                <option value="108">Vroom</option>
                                <option value="109">Weber</option>
                                <option value="110">Levis</option>

                            </select>
                            <label for="floatingSelect">Select Program</label>
                        </div>
                        <div class="">
                            <label class="fw-bold" style="margin-bottom: 2%">Select Locations:</label>
                            <br>
                            <div style="display: inline-block; margin-right: 12%; margin-left: 5%">
                                <div>
                                    <label>
                                        <input type="checkbox" name="locations[]" value="101" />
                                        <span>Bogotá</span>
                                    </label>
                                </div>
                                <div>
                                    <label>
                                        <input type="checkbox" name="locations[]" value="201" />
                                        <span>Medellín</span>
                                    </label>
                                </div>
                                <div>
                                    <label>
                                        <input type="checkbox" name="locations[]" value="301" />
                                        <span>Bucaramanga</span>
                                    </label>
                                </div>
                            </div>
                            <div style="display: inline-block">
                                <div>
                                    <label>
                                        <input type="checkbox" name="locations[]" value="401" />
                                        <span>Barranquilla</span>
                                    </label>
                                </div>
                                <div>
                                    <label>
                                        <input type="checkbox" name="locations[]" value="501" />
                                        <span>Cali</span>
                                    </label>
                                </div>
                            </div>


                        </div>
                        <br>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" style="padding-left: 5px;" name="floatingName"
                                placeholder="nameWave" required>
                            <label for="floatingInput" class="fw-bold">Name Wave</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" style="padding-left: 5px;" name="floatingDate"
                                placeholder="yyyy-mm-dd" required>
                            <label for="floatingInputGrid">Start Date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" style="padding-left: 5px;"
                                name="floatingInspector" placeholder="Itops Inspector" required>
                            <label for="floatingInput">Itops Inspector</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div> {{-- End Modal --}}

    <!-- Modal to Delete Wave -->
    <div class="modal fade" id="DeleteWaveModal" style="background: none; box-shadow: none; width: 600px"
        data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Wave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/home/wave/delete" method="POST">
                    @csrf
                    <input type="hidden" name="IdWave" value="{{ $wave->IdWave }}">
                    <div class="modal-body">
                        <p>Are you sure that want to delete this wave?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn red">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div> {{-- End Modal to Delete Wave --}}
@endsection
