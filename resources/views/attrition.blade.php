@extends('layouts.app')
@section('content')
    <div class="attrition" style="width: 80%; margin: auto">
        <div class="row justify-content-center">
            <div class="col-md-13">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline-block fw-bold" style="width: 40%;">
                            <a href="#" style="color: black;">Attrition</a>
                        </div>
                        <div style="display: inline-block; text-align: end; width: 59%;">
                            <button type="button" class="btn-flat fw-bold border-start border-end border-3"
                                id="btn-attrition-insert" style="font-size: 12px" data-bs-toggle="modal"
                                data-bs-target="#modalInsert">INSERT</button>
                        </div>
                    </div>
                    <div class="card-body" style="height: max-content">
                        @if (session()->has('message'))
                            <div class="alert alert-{{ session()->get('alert') }}" role="alert"
                                style="width: 100%; margin: auto;">
                                {{ session()->get('message') }}
                                @if (session()->has('th'))
                                    <div class="accordion" id="accordionExample" style="background-color: none;">

                                        <div class="accordion-item" style="border-color: black;">
                                            <h2 class="accordion-header" id="headingThree"
                                                style=" background-color: none; margin-top: 0px;">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    <strong style="overflow: hidden; max-height: 18px ">
                                                        {{ session()->get('th') }}</strong>
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <strong> {{ session()->get('th') }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="content-attrition">
                            <table style="font-size: 12px;">
                                <thead>
                                    <tr class="grey darken-3" style="color: white;">
                                        <th class="border-end text-center">CODE</th>
                                        <th class="border-end text-center">NAME</th>
                                        <th class="border-end text-center">USERNAME</th>
                                        <th class="border-end text-center">PROGRAM</th>
                                        <th class="border-end text-center">HARDWARE</th>
                                        <th class="border-end text-center">WORKSTATION</th>
                                        <th class="border-end text-center">SERIAL</th>
                                        <th class="border-end text-center">ATTRITION-EXCHANGE</th>
                                        <th class="border-end text-center">HARDWARE RETURNED</th>
                                        <th class="border-end text-center">TRANSFER TO</th>
                                        <th class="border-end text-center">ATTRITION DATE</th>
                                        <th class="border-end text-center">TESTED DATE</th>
                                        <th class="border-end text-center">NEW COMPUTER</th>
                                        <th class="border-end text-center">COMMENTS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <form action="/attrition/update_user" method="POST">
                                            @csrf

                                            @if ($row->hardware_returned == 'checking')
                                                <tr class="yellow lighten-3">
                                            @endif
                                            @if ($row->hardware_returned == 'yes')
                                                <tr class="green lighten-3">
                                            @endif

                                            @if ($row->hardware_returned == 'no')
                                                <tr class="red lighten-3">
                                            @endif
                                            <td class="border-end">

                                                <input type="text" name="id" value="{{ $row->id }}"
                                                    style="display: none">
                                                <input type="text" name="cde"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center; font-weight: bold"
                                                    value={{ $row->cde }} readonly>
                                            </td>
                                            <td class="border-end"
                                                style="background: none; font-size: 12px; color: black; border: none; text-align: center; font-weight: bold">
                                                {{ $row->user->name }}</td>
                                            <td class="border-end"><input type="text" name="username"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center; font-weight: bold"
                                                    value={{ $row->user->username }} readonly></td>
                                            <td class="border-end text-center"><input type="text" name="program"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center; font-weight: bold"
                                                    value={{ $row->program->Name }} readonly></td>
                                            <td class="border-end"><input type="text" name="hardware"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center; font-weight: bold"
                                                    value={{ $row->hardware == 1 ? 'yes' : 'no' }} readonly></td>
                                            <td class="border-end"><input type="text" name="host"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center; font-weight: bold"
                                                    value="{{ $row->computer->HostName ?? '' }}" readonly></td>
                                            <td class="border-end"><input type="text" name="serial"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center; font-weight: bold"
                                                    value="{{ $row->SerialNumber }}" readonly></td>
                                            <td class="border-end">
                                                <select class="form-select bg-transparent fw-bold"
                                                    style="width: min-content" name="wfs"
                                                    aria-label="Default select example">
                                                    <option selected>{{ $row->wfs_attrition }}</option>
                                                    <option value="attrition">attrition</option>
                                                    <option value="exchange">exchange</option>
                                                    <option value="transfer">transfer</option>
                                                </select>
                                            </td>
                                            <td class="border-end text-center">
                                                <select class="form-select bg-transparent fw-bold" name="returned"
                                                    aria-label="Default select example">
                                                    <option selected> {{ $row->hardware_returned }}</option>
                                                    <option value="yes">yes</option>
                                                    <option value="no">no</option>
                                                    <option value="checking">checking</option>
                                                </select>
                                            </td>
                                            <td class="border-end"><input type="text" name="new_wave" id="new_wave"
                                                    autocomplete="off"
                                                    style="background: transparent; ; font-size: 12px; color: black; border: none; text-align: center; font-weight: bold"
                                                    value={{ $row->new_wave ?? '' }}></td>
                                            <td class="border-end text-center"><input type="text" name="at_date"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center; font-weight: bold"
                                                    value={{ $row->attrition_date }} readonly></td>
                                            <td class="border-end"><input type="text" name="test_date"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center; font-weight: bold"
                                                    value="{{ $row->tested_date }}" readonly></td>
                                            <td class="border-end"><input type="text" name="new_host"
                                                    autocomplete="off"
                                                    style="background: transparent; ; font-size: 12px; color: black; border: none; text-align: center; font-weight: bold"
                                                    value={{ $row->newComputer->HostName ?? '' }}></td>
                                            <td class="border-end fw-bold" style="text-align: center">
                                                @if ($row->comments)
                                                    {{-- Button trigger Modal AddComment --}}
                                                    <button type="button"
                                                        style="background: transparent; ; font-size: 12px; border: none; text-align: center; font-weight: bold"
                                                        class="waves-effect waves-light" data-bs-toggle="modal"
                                                        data-bs-target="#AddComment{{ $row->id }}">{{ $row->comments }}</button>
                                                @else
                                                    {{-- Button trigger Modal AddComment --}}
                                                    <button type="button" style="background: none; border: none"
                                                        class="waves-effect waves-light" data-bs-toggle="modal"
                                                        data-bs-target="#AddComment{{ $row->id }}"><i
                                                            class="material-icons">add_circle</i></button>
                                                @endif
                                            </td>
                                            <td class="bg-white"> <button type="submit"
                                                    class="bg-transparent border-white" style="border: none"><i
                                                        class="material-icons">save</i></button></td>
                                        </form>
                                        <td class="bg-white">
                                            {{-- Button trigger DeleteWaveModal --}}
                                            <button type="submit" style="background: none; border: none"
                                                class="waves-effect waves-light" data-bs-toggle="modal"
                                                data-bs-target="#DeleteAttritionModal{{ $row->id }}"><i
                                                    class="material-icons">delete</i></button>
                                            <!-- Modal to Delete Attrition -->
                                            <div class="modal fade" id="DeleteAttritionModal{{ $row->id }}"
                                                style="background: none; box-shadow: none; width: 600px"
                                                data-bs-backdrop="static" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                Delete Attrition</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('attrition.deleteUser') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $row->id }}">
                                                            <div class="modal-body">
                                                                <p>Are you sure that want to delete this
                                                                    user({{ $row->user->name }}) in attrition?
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary me-3"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn red">Yes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> {{-- End Modal to Delete Wave --}}
                                        </td>

                                        </tr>
                                        <!-- Modal to AddComment -->
                                        <div class="modal fade" id="AddComment{{ $row->id }}"
                                            style="background: none; box-shadow: none; width: 600px"
                                            data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Add Comment</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('attrition.addComment') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id"
                                                            value="{{ $row->id }}">
                                                        <div class="modal-body">
                                                            <div class="form-floating mb-1 ">
                                                                <input type="text" name="comment" class="form-control"
                                                                    placeholder="comment" id="comment"
                                                                    autocomplete="off" value="{{ $row->comments }}">
                                                                <label for="floatingInput" class="fw-bold">Comment</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn me-3 grey"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn blue">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> {{-- End Modal to Delete Wave --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal INSERT USER TO ATTRITION -->
    <div class="modal fade" id="modalInsert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background: none; box-shadow: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form enctype="multipart/form-data" class="" method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            Search User
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3 ">
                            <input type="text" name="name_user" class="form-control" placeholder="fullname"
                                id="fullname" autocomplete="off" required>
                            <label for="floatingInput" class="fw-bold">FullName</label>
                        </div>
                        <div class="form-floating mb-3 ">
                            <input type="text" name="cde" class="form-control" placeholder="code" id="cde"
                                autocomplete="off">
                            <label for="floatingInput" class="fw-bold">Code</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary grey" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary blue" style="margin-left: 20px;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Modal INSERT USER TO ATTRITION -->
@endsection
