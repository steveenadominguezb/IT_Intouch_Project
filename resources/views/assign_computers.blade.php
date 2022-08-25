@extends('wave')
@section('assign')
    <div class="computers" style="width: 70%; margin: auto">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card" style="max-height: 700px; overflow: auto;">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 49%;">
                            {{ __('Computers') }}
                        </div>


                    </div>

                    <div class="card-body " style="display: table;border-spacing: 40px; overflow: scroll;">
                        <div class="border-end" style=" width: 40%; display: table-cell; ">
                            <div style=" margin-bottom: 30px;">
                                <div style="margin-left: 10%; display: inline-block; width: 35%;"
                                    class=" border-end border-3">
                                    <form action="">
                                        <div style="width: 40%; display: inline-block;margin-right: 20px;">
                                            <input type="text" name="text">
                                        </div>
                                        <div class="" style="display: inline-block;">
                                            <button type="submit" class="btn btn-primary fw-bold">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <div style="margin-left: 5%; display: inline-block; width: 48%;">
                                    <form enctype="multipart/form-data" action="" method="POSt">
                                        @csrf
                                        <div style="display: inline-block">
                                            <input type="file" name="file">
                                        </div>
                                        <div style="display: inline-block">
                                            <button type="submit" id="btn_register"
                                                class="btn blue fw-bold">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <form action="" method="POST">
                                @csrf
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
                                                    <div style="display: inline-block;">
                                                        <label>
                                                            <input type="checkbox" name="assign[]"
                                                                value="{{ $computer->SerialNumber }}" />
                                                            <span></span>
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
