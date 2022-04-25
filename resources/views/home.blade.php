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
                        <button class="fw-bold fs-3" style="border: none; background: none;">+</button>
                    </div>

                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="card h-5 d-inline-block" style="width: 18rem;">
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
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection