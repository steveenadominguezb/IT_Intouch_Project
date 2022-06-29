
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 49%;">
                            {{ __('Inventory') }}
                        </div>


                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div style="text-align: center; margin-bottom: 30px;">
                            <form action="">
                                <div style="width: 40%; display: inline-block;margin-right: 20px;">
                                    <input type="text" name="text">
                                </div>
                                <div class="" style="display: inline-block;">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                        <form action="" method="POST">
                            @csrf
                            <div style="height: 700px; overflow: auto;">
                                @if (session()->has('message'))
                                    <div class="alert alert-{{ session()->get('alert') }}" role="alert">
                                        {{ session()->get('message') }}
                                        @if (session()->has('th'))
                                            <div class="accordion" id="accordionExample" style="background-color: none;">

                                                <div class="accordion-item" style="border-color: black;">
                                                    <h2 class="accordion-header" id="headingThree"
                                                        style=" background-color: none; margin-top: 0px;">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                            aria-expanded="false" aria-controls="collapseThree">
                                                            See more about the error
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
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">IdComponent</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Brand</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventory as $item)
                                            <tr>
                                                <th scope="row">{{ $item->IdComponent }}</th>
                                                <td>{{ $item->Description }}</td>
                                                <td>{{ $item->Brand }}</td>
                                                <td>{{ $item->Quantity }}</td>
                                                <td>
                                                    <div class="form-check" style="display: inline-block;">
                                                        <label>
                                                            <input type="checkbox" name="assign[]" />

                                                            <span class="fw-bold"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
