@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register Computer') }}</div>

                <div class="card-body">
                    <form enctype="multipart/form-data" class="" method="POST" action="">
                        @csrf
                        <div>
                            <div class="box1">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="serial" placeholder="nameWave" id="serial">
                                    <label class="fw-bold" for="floatingInput">SerialNumber</label>
                                </div>
                                @error('serial')
                                <p class="alert alert-danger w-100" role="alert">
                                    {{ $message }}
                                </p>
                                @enderror
                                <div class="form-floating mb-3 ">
                                    <input type="text" class="form-control" name="host" placeholder="host" id="host">
                                    <label class="fw-bold" for="floatingInput">HostName</label>
                                </div>
                                @error('host')
                                <p class="alert alert-danger w-100" role="alert">
                                    {{ $message }}
                                </p>
                                @enderror
                                <div class="form-floating mb-3 ">
                                    <input type="text" class="form-control" name="os" placeholder="os" id="os">
                                    <label class="fw-bold" for="floatingInput">OS</label>
                                </div>
                                @error('os')
                                <p class="alert alert-danger w-100" role="alert">
                                    {{ $message }}
                                </p>
                                @enderror

                            </div>

                            <div class="box2">
                                <div class="form-check">
                                    <label>
                                        <input type="checkbox" name="laptop" />
                                        <span class="fw-bold">Is a Laptop</span>
                                    </label>
                                </div>
                                <div class="form-floating mb-3 ">
                                    <input type="text" class="form-control" name="brand" placeholder="brand" id="brand">
                                    <label class="fw-bold" for="floatingInput">Brand</label>
                                </div>
                                @error('brand')
                                <p class="alert alert-danger w-100" role="alert">
                                    {{ $message }}
                                </p>
                                @enderror
                                <div class="form-floating mb-3 ">
                                    <input type="text" class="form-control" name="model" placeholder="model" id="model">
                                    <label class="fw-bold" for="floatingInput">Model</label>
                                </div>
                                @error('model')
                                <p class="alert alert-danger w-100" role="alert">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div style="text-align: center;margin-top: 30px;">
                            <input type="file" name="file">
                        </div>
                        <button type="submit" class="but-register btn btn-success d-block fw-bold">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection