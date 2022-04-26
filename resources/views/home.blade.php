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


                    <div class="card d-inline-block me-5" style="width: 15rem;">
                        <img src="img/{{$wave->programs->img}}" class="card-img-top" alt="...">
                        <div class="card-body">

                            <p class="card-text fw-bold">{{$wave->programs->Name}}</p>
                            <p class="card-text fw-bold">{{ $wave->Name}}</p>
                        </div>
                    </div>
                    @endforeach
                    <!-- <div class="card h-5 d-inline-block" style="width: 18rem;">
                        <img src="{{ asset('img/booking.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text fw-bold">Booking CSG Spa Wave 29</p>
                        </div>
                    </div>
                    <div class="card d-inline-block" style="width: 18rem;">
                        <img src="{{ asset('img/spark.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text fw-bold">Spark Delivery Wave 47B</p>
                        </div>
                    </div> -->

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
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection