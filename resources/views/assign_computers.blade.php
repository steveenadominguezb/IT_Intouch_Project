@extends('wave')
@section('assign')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card">
                <div class="card-body" style="height: max-content; width: 100%;">
                    <table style="margin-left: 10%; width: 80%">
                        <thead>
                            <tr>
                                <th>SerialNumber</th>
                                <th>WorkStation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($computers as $computer)
                            <tr>
                                <td>{{ $computer->SerialNumber }}</td>
                                <td>{{ $computer->HostName }}</td>
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