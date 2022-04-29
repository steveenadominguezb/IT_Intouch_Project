@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register Computer') }}</div>

                <div class="card-body">
                    <form class="" method="POST" action="">
                        @csrf
                        <div class="box1">
                            <div class="mb-3 ">
                                <label class="form-label fw-bold">SerialNumber</label>
                                <input type="text" name="serial" class="form-control" id="serial">
                            </div>
                            @error('serial')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>
                            @enderror
                            <div class="mb-3 ">
                                <label class="form-label fw-bold">HostName</label>
                                <input type="text" name="host" class="form-control" id="host">
                            </div>
                            @error('host')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>
                            @enderror
                            <div class="mb-3 ">
                                <label class="form-label fw-bold w-100 text-cente">OS</label>
                                <input type="text" name="os" class="form-control" id="os">
                            </div>
                            @error('os')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>

                        <div class="box2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="laptop" value="true">
                                <label class="form-check-label fw-bold" for="flexCheckChecked">
                                    Is a Laptop
                                </label>
                            </div>
                            <br>
                            <div class="mb-3 ">
                                <label class="form-label fw-bold">Brand</label>
                                <input type="text" name="brand" class="form-control" id="brand">
                            </div>
                            @error('brand')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>
                            @enderror
                            <div class="mb-3 ">
                                <label class="form-label fw-bold">Model</label>
                                <input type="text" name="model" class="form-control" id="model">
                            </div>
                            @error('model')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>
                            @enderror
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select class="form-select" name="status">
                                    <!-- <option selected>None</option> -->
                                    <option value="InStorage">Storage</option>
                                    <option value="Taken">Taken</option>
                                    <option value="Damaged">Damaged</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="but-register btn btn-success d-block fw-bold">Submit</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection