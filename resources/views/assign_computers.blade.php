@extends('wave')
@section('assign')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card">
                <div class="card-body" style="height: max-content; width: 100%;">
                
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
                                        <th>SerialNumber</th>
                                        <th>WorkStation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($computers as $computer)
                                    <tr>
                                        <td>{{ $computer->SerialNumber }}</td>
                                        <td>{{ $computer->HostName }}</td>
                                        <td>
                                            <div class="form-check">
                                                <label>
                                                    <input type="checkbox" name="assign[]" value="{{$computer->SerialNumber}}"/>
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