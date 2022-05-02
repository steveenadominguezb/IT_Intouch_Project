@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline-block" style="width: 50%;">
                        {{ __('Dashboard') }}
                    </div>
                    <div class="d-inline-block text-end" style="width: 49%;">
                        <button class="fw-bold fs-3 " style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#exampleModal">+</button>

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
                        <div class="card ">
                            <div class=" card-image waves-effect waves-block waves-light small">
                                <img class="activator" style="height: fit-content;" src="img/{{$wave->programs->img}}" alt="program image">
                            </div>
                            <div class="card-content border">
                                <span class="card-title activator grey-text text-darken-4 fw-bold">{{$wave->programs->Name}}<i class="material-icons right">more_vert</i></span>
                                <p class="card-text fw-bold">{{ $wave->Name}}</p>
                                <p>{{ $wave->StartDate }}</p>
                            </div>
                            <div class="card-reveal">
                                <span class="card-title grey-text text-darken-4">{{ $wave->Name}}<i class="material-icons right">close</i></span>
                                <p>Here is some more information about this product that is only revealed once clicked on.</p>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Wave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('wave.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="form-floating mb-3">
                        <select class="form-select" name="floatingSelect" aria-label="Floating label select example" required>
                            <option selected>Open this select menu</option>
                            <option value="101">TCP</option>
                            <option value="102">GNC</option>
                            <option value="103">Optavia</option>
                            <option value="104">Airbnb</option>
                            <option value="105">Booking</option>
                            <option value="106">L'oreal</option>
                            <option value="107">Walmart Spark</option>
                            <option value="108">Vroom</option>
                            <option value="109">Weber</option>
                            <option value="110">Levis</option>

                        </select>
                        <label for="floatingSelect">Select Program</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="floatingName" placeholder="nameWave" required>
                        <label for="floatingInput">Name Wave</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" name="floatingDate" placeholder="yyyy-mm-dd" value="yyyy-mm-dd" required>
                        <label for="floatingInputGrid">Start Date</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="floatingInspector" placeholder="Itops Inspector" required>
                        <label for="floatingInput">Itops Inspector</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection