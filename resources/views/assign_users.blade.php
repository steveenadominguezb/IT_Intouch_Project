@extends('wave')
@section('assign')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card">
                <div class="card-body" style="height: max-content">
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
                        <div style="height: 700px; overflow: scroll;">
                            <table style="margin-left: 10%; width: 80%">
                                <thead>
                                    <tr>
                                        <th>CODE</th>
                                        <th>Full Name</th>
                                        <th>Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->cde }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->position }}</td>
                                        <td>
                                            <div class="form-check">
                                                <label>
                                                    <input type="checkbox" name="assign[]" value="{{$user->cde}}" />
                                                    <span class="fw-bold"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="text-align: right;">
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection