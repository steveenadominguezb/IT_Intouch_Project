@extends('wave')
@section('assign')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card">
                <div class="card-body" style="height: max-content">
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
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection