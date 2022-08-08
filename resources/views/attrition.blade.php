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
                                style="font-size: 12px" data-bs-toggle="modal" data-bs-target="#modalInsert">INSERT</button>
                        </div>
                    </div>
                    <div class="card-body" style="height: max-content">
                        @if (session()->has('message'))
                            <div class="alert alert-{{ session()->get('alert') }}" role="alert"
                                style="width: 65%; margin: auto;">
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
                        <div>
                            <table style="font-size: 12px;">
                                <thead>
                                    <tr class="black" style="color: white;">
                                        <th class="border-end text-center">CODE</th>
                                        <th class="border-end text-center">NAME</th>
                                        <th class="border-end text-center">USERNAME</th>
                                        <th class="border-end text-center">PROGRAM</th>
                                        <th class="border-end text-center">HARDWARE</th>
                                        <th class="border-end text-center">WORKSTATION</th>
                                        <th class="border-end text-center">SERIAL</th>
                                        <th class="border-end text-center">WFS-ATTRITION</th>
                                        <th class="border-end text-center">HARDWARE RETURNED</th>
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
                                                <tr class="yellow">
                                            @endif
                                            @if ($row->hardware_returned == 'yes')
                                                <tr class="green">
                                            @endif

                                            @if ($row->hardware_returned == 'no')
                                                <tr class="red">
                                            @endif
                                            <td class="border-end">

                                                <input type="text" name="id" value="{{ $row->id }}" style="display: none">
                                                <input type="text" name="cde"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center"
                                                    value={{ $row->cde }} readonly>
                                            </td>
                                            <td class="border-end"><input type="text" name="name"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center;"
                                                    value="{{ $row->user->name }}" readonly></td>
                                            <td class="border-end"><input type="text" name="username"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center"
                                                    value={{ $row->user->username }} readonly></td>
                                            <td class="border-end text-center"><input type="text" name="program"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center"
                                                    value={{ $row->program->Name }} readonly></td>
                                            <td class="border-end"><input type="text" name="hardware"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center"
                                                    value={{ $row->hardware == 1 ? 'yes' : 'no' }} readonly></td>
                                            <td class="border-end"><input type="text" name="host"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center"
                                                    value="{{ $row->computer->HostName ?? '' }}" readonly></td>
                                            <td class="border-end"><input type="text" name="serial"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center"
                                                    value="{{ $row->SerialNumber }}" readonly></td>
                                            <td class="border-end">
                                                <select class="form-select bg-transparent" style="width: min-content"
                                                    name="wfs" aria-label="Default select example">
                                                    <option selected>{{ $row->wfs_attrition }}</option>
                                                    <option value="attrition">attrition</option>
                                                    <option value="wfs">work on site</option>
                                                </select>
                                            </td>
                                            <td class="border-end text-center">
                                                <select class="form-select bg-transparent" name="returned"
                                                    aria-label="Default select example">
                                                    <option selected> {{ $row->hardware_returned }}</option>
                                                    <option value="yes">yes</option>
                                                    <option value="no">no</option>
                                                </select>
                                            </td>
                                            <td class="border-end text-center"><input type="text" name="at_date"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center"
                                                    value={{ $row->attrition_date }} readonly></td>
                                            <td class="border-end"><input type="text" name="test_date"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center"
                                                    value="{{ $row->tested_date }}" readonly></td>
                                            <td class="border-end"><input type="text" name="new_serial"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center"
                                                    value={{ $row->newComputer->HostName ?? '' }}></td>
                                            <td class="border-end"><input type="text" name="comment"
                                                    style="background: none; font-size: 12px; color: black; border: none; text-align: center"
                                                    value="{{ $row->comments }}" readonly></td>
                                            <td class="bg-white"> <button type="submit"
                                                    class="bg-transparent border-white"><i
                                                        class="material-icons">save</i></button></td>
                                            </tr>
                                        </form>
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
                        @csrf
                        <div style="display: inline-block">
                            <input type="text" name="name_user">
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
