@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register Employee') }}</div>

                <div class="card-body">
                    <form class="" method="POST" action="">
                        @csrf
                        <div class="box1">
                            <div class="mb-3 ">
                                <label for="exampleInputEmail1" class="form-label fw-bold">Code</label>
                                <input type="text" name="cde" class="form-control" id="code" aria-describedby="emailHelp">
                            </div>
                            @error('cde')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>

                            @enderror
                            <div class="mb-3 ">
                                <label for="exampleInputEmail1" class="form-label fw-bold">FullName</label>
                                <input type="text" name="name" class="form-control" id="fullname" aria-describedby="emailHelp">
                            </div>
                            @error('name')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>

                            @enderror
                            <div class="mb-3 ">
                                <label for="exampleInputEmail1" class="form-label fw-bold">Position</label>
                                <input type="text" name="position" class="form-control" id="position" aria-describedby="emailHelp">
                            </div>
                            @error('position')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>

                            @enderror
                            <div class="mb-3 ">
                                <label for="exampleInputEmail1" class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                            </div>
                            @error('email')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>

                            @enderror
                            <div class="mb-3 ">
                                <label for="exampleInputEmail1" class="form-label fw-bold">Contact Number</label>
                                <input type="number" name="number" class="form-control" id="number" aria-describedby="emailHelp">
                            </div>
                            @error('number')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>

                            @enderror
                        </div>

                        <div class="box2">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label fw-bold">Username</label>
                                <input type="text" name="UserName" class="form-control" id="UserName" aria-describedby="emailHelp">
                            </div>
                            @error('UserName')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>

                            @enderror
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            @error('Password')
                            <p class="alert alert-danger w-100" role="alert">
                                {{ $message }}
                            </p>

                            @enderror
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label fw-bold">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Privileges</label>
                                <select class="form-select" name="SelectPrivileges" aria-label="Privileges">
                                    <!-- <option selected>None</option> -->
                                    <option value="10001">Admin</option>
                                    <option value="20001">None</option>
                                    <option value="30001">IT</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="but-register btn btn-success fw-bold d-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection