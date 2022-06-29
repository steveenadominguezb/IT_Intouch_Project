@extends('wave')
@section('assign')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card" style="max-height: 700px; overflow: auto;">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 49%;">
                            {{ __('Inventory Updates') }}
                        </div>


                    </div>
                    <div class="card-body">
                        <div style="display: inline-block; width: 48%">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">IdComponent</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventory as $item)
                                        <tr>
                                            <th scope="row">{{ $item->IdComponent }}</th>
                                            <td>{{ $item->Description }}</td>
                                            <td>{{ $item->Brand }}</td>
                                            <td>{{ $item->Quantity }}</td>
                                            <td>
                                                <div class="form-check" style="display: inline-block;">
                                                    <label>
                                                        <input type="checkbox" name="assign[]" />

                                                        <span class="fw-bold"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="display: inline-block; width: 48%">

                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
