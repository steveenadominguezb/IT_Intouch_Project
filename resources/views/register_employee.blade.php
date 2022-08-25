@extends('layouts.app')

@section('content')
    <div class="content_preloader" id="content_preloader">
        <div class="preloader-wrapper big active big">
            <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register Employee') }}</div>

                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-{{ session()->get('alert') }}" role="alert"
                                style="width: 65%; margin: auto;">
                                <strong> {{ session()->get('message') }}</strong>
                                @if (session()->has('th'))
                                    <div class="accordion" id="accordionExample" style="background-color: none;">

                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item" style="border-color: black;">
                                                <h2 class="accordion-header" id="headingThree"
                                                    style=" background-color: none; margin-top: 0px;">
                                                    <button class="accordion-button accordion-button-warning collapsed"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseThree" aria-expanded="false"
                                                        aria-controls="collapseThree">
                                                        @if (session()->has('fails') && session()->has('mes'))
                                                            <strong>

                                                                {{ session()->get('mes')[0] }}:</strong>
                                                        @else
                                                            <strong style="overflow: hidden; max-height: 18px ">
                                                                {{ session()->get('th') }}</strong>
                                                        @endif
                                                    </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse collapse"
                                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        @if (session()->has('fails') && session()->has('mes'))
                                                            <strong>
                                                                ({{ session()->get('fails') }}){{ session()->get('mes')[1] }}</strong>
                                                        @else
                                                            {{ session()->get('th') }}
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            </div>
                        @endif
                        <form enctype="multipart/form-data" class="" method="POST" action="">
                            @csrf
                            <div class="box1">
                                <div class="form-floating mb-3 ">
                                    <input type="text" class="form-control" name="cde" placeholder="code"
                                        id="code">
                                    <label for="floatingInput" class="fw-bold">Code</label>
                                </div>
                                @error('cde')
                                    <p class="alert alert-danger w-100" role="alert">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div class="form-floating mb-3 ">
                                    <input type="text" name="name" class="form-control" placeholder="fullname"
                                        id="fullname">
                                    <label for="floatingInput" class="fw-bold">FullName</label>
                                </div>
                                @error('name')
                                    <p class="alert alert-danger w-100" role="alert">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div class="form-floating mb-3 ">
                                    <input type="text" name="position" class="form-control" placeholder="position"
                                        id="position">
                                    <label for="floatingInput" class="fw-bold">Position</label>
                                </div>
                                @error('position')
                                    <p class="alert alert-danger w-100" role="alert">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div class="form-floating mb-3 ">
                                    <input type="email" name="email" class="form-control" placeholder="email"
                                        id="email">
                                    <label for="floatingInput" class=" fw-bold">Email</label>
                                </div>
                                @error('email')
                                    <p class="alert alert-danger w-100" role="alert">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div class="form-floating mb-3 ">
                                    <input type="number" name="number" class="form-control" placeholder="number"
                                        id="number">
                                    <label for="floatingInput" class=" fw-bold">Contact Number</label>
                                </div>
                                @error('number')
                                    <p class="alert alert-danger w-100" role="alert">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="box2">
                                <div class="form-floating mb-3">
                                    <input type="text" name="UserName" class="form-control" placeholder="UserName"
                                        id="UserName">
                                    <label for="floatingInput" class=" fw-bold">Username</label>
                                </div>
                                @error('UserName')
                                    <p class="alert alert-danger w-100" role="alert">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div class="form-floating mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="password"
                                        id="password">
                                    <label for="floatingInput" class=" fw-bold">Password</label>
                                </div>
                                @error('password')
                                    <p class="alert alert-danger w-100" role="alert">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div class="form-floating mb-3">
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="confirmpassword" id="confirmpassword">
                                    <label for="floatingInput" class=" fw-bold">Confirm Password</label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Privileges</label>
                                    <select class="form-select" name="SelectPrivileges" aria-label="Privileges"
                                        style="height: 6%;">
                                        <!-- <option selected>None</option> -->
                                        <option value="40001">Agent</option>
                                        <option value="30001">IT</option>
                                        <option value="50001">HR</option>
                                        <option value="20001">None</option>
                                    </select>
                                </div>
                            </div>
                            <div style="text-align: center;margin-top: 30px;">
                                <input type="file" name="file">
                            </div>
                            <button type="submit" id="btn_register" class="but-register btn btn-success fw-bold d-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
