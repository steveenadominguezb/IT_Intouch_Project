@extends('layouts.app')
@section('content')
    <div class="attrition" style="width: 70%; margin: auto">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 40%;">
                            <a href="#" style="color: black;">Attrition</a>
                        </div>
                        <div style="display: inline-block; text-align: end; width: 59%;">
                            <a href="#" class="btn-flat fw-bold border-start border-end border-3"
                                style="font-size: 12px">INSERT</a>
                        </div>
                    </div>
                    <div class="card-body" style="height: max-content">
                        @if (session()->has('message'))
                            <div class="alert alert-{{ session()->get('alert') }}" role="alert"
                                style="width: 65%; margin: auto;">
                                {{ session()->get('message') }}
                                @if (session()->has('th'))
                                    <div class="accordion" id="accordionExample" style="background-color: none;">

                                        <div class="accordion-item" style="border-color: black;">
                                            <h2 class="accordion-header" id="headingThree"
                                                style=" background-color: none; margin-top: 0px;">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    <strong style="overflow: hidden; max-height: 18px ">
                                                        {{ session()->get('th') }}</strong>
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <strong> {{ session()->get('th') }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
