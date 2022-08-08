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
                            <button type="button" class="btn-flat fw-bold border-start border-end border-3"
                                style="font-size: 12px" data-bs-toggle="modal" data-bs-target="#modalInsert">INSERT</button>
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
                            @foreach ($rows as $row)
                                {{ $row->cde }}
                                {{ $row->user->name }}
                                @if ($row->SerialNumber != null)
                                    {{ $row->SerialNumber }}
                                @else
                                    null
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal INSERT USER TO ATTRITION -->
    <div class="modal fade" id="modalInsert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background: none; box-shadow: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form enctype="multipart/form-data" class="" method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            Search User
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div style="display: inline-block">
                            <input type="text" name="name_user">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary grey" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary blue" style="margin-left: 20px;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Modal INSERT USER TO ATTRITION -->
@endsection
