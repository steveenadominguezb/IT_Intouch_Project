@extends('wave')
@section('assign')
    <div class="users" style="width: 70%; margin: auto">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card" style="max-height: 700px; overflow: auto;">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 49%;">
                            {{ __('Users') }}
                        </div>


                    </div>

                    <div class="card-body " style="display: table;border-spacing: 40px; overflow: scroll;">
                        <div class="border-end" style=" width: 40%; display: table-cell; ">
                            <div style="text-align: center; margin-bottom: 30px;">
                                <form action="">
                                    <div style="width: 40%; display: inline-block;margin-right: 20px;">
                                        <input type="text" name="text">
                                    </div>
                                    <div class="" style="display: inline-block;">
                                        <button type="submit" id="btn_register" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                            <form action="" method="POST">
                                @csrf
                                <table style="margin-left: 10%; width: 80%; ">
                                    <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>Full Name</th>
                                            <th>UserName</th>
                                            <th>Position</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->cde }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->position }}</td>
                                                <td>
                                                    <div class="form-check">
                                                        <label>
                                                            <input type="checkbox" name="assign[]"
                                                                value="{{ $user->cde }}" />
                                                            <span class="fw-bold"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                        </div>

                    </div>
                </div>
                <div style="text-align: right;">
                    <button type="submit" id="btn_register" class="btn btn-primary">Assign</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
