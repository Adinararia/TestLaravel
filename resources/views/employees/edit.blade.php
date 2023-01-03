@extends('layouts.adminlte')
@section('title', 'Edit employee')

@section('myContentHeader')
    <h1>Employees</h1>
@endsection



@section('myContent')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit employee -  {{$employee->name}}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form method="post" action="{{route('employees.update', $employee->id)}}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                @if($employee->image)
                <img src="{{ asset($employee->image)}}" width="300px" height="300">
                @endif
                <x-adminlte-input-file value="{{$employee->image}}" placeholder="{{$employee->image}}" name="image" label="Photo">
                    <x-slot name="bottomSlot">
                          <span class="text-sm text-gray">
                                  File format jpg,png up to 5 MB, the minimum size of 300x300px
                            </span>
                    </x-slot>
                </x-adminlte-input-file>
                <div class="row">
                    <x-adminlte-input value="{{$employee->name}}" name="name" label="Name" data-max="256" placeholder="Name employee" fgroup-class="col-md-6"  enable-old-support>
                    </x-adminlte-input>
                </div>
                <div class="row">
                    <x-adminlte-input value="{{$employee->phone}}" name="phone" label="Phone" placeholder="Phone" fgroup-class="col-md-6"  enable-old-support>

                        <x-slot name="bottomSlot">
                          <span class="text-sm text-gray">
                                   Requeired format +380 (XX) XXX XX XX
                            </span>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="row">
                    <x-adminlte-input value="{{$employee->email}}" name="email" label="Email" placeholder="Email" type="email" fgroup-class="col-md-6"  enable-old-support>
                    </x-adminlte-input>
                </div>


                <x-adminlte-select label="Position" name="position" >
                    <x-adminlte-options :options="$select" disabled="1"/>
                    <option value="{{$employee->position_id}}" selected> {{$employee->position->name}}</option>
                </x-adminlte-select>


                <div class="row">
                    <x-adminlte-input value="{{$employee->salary}}" name="salary" label="Salary" type="number" placeholder="Salary" fgroup-class="col-md-6"  enable-old-support   igroup-size="sm" min=0.001 step="0.001" max=500>
                    </x-adminlte-input>
                </div>

                <div class="row">
                    <x-adminlte-input value="{{$employee->getManagerName($employee->manager_id)->name}}" name="head" id="head" label="Head" placeholder="Head" fgroup-class="col-md-6"  enable-old-support>
                        <x-slot name="appendSlot">
                            <x-adminlte-input value="{{$employee->manager_id}}" id="hide_head" name="hide_head" type="hidden" fgroup-class="col-md-6"  enable-old-support>
                            </x-adminlte-input>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                @php
                    $config = [
                        "singleDatePicker" => true,
                        "showDropdowns" => true,
                        "startDate" => "js:moment()",
                        "minYear" => 2000,
                        "maxYear" => "js:parseInt(moment().format('YYYY'),10)",
                        "timePicker" => true,
                        "timePicker24Hour" => true,
                        "timePickerSeconds" => true,
                        "cancelButtonClasses" => "btn-danger",
                        "locale" => ["format" => "DD.MM.YYYY"],
                    ];
                @endphp
                <x-adminlte-date-range value="{{$employee->reception}}" name="date" label="Date" igroup-size="sm" :config="$config">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-dark">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </x-slot>
                </x-adminlte-date-range>

                <div class="row">
                    <p style="margin-right: 50px"><b>Created at:</b> {{$employee->created_at}} </p>
                    <p><b>Admin created ID:</b> {{$employee->admin_created_id}} </p>

                </div>
                <div class="row">
                    <p style="margin-right: 50px"><b>Updated at:</b> {{$employee->updated_at}}</p>
                    <p><b>Admin updated ID:</b> {{$employee->admin_updated_id}}</p>
                </div>

                <a href="{{route('employees.index')}}"> <x-adminlte-button type="button" label="Cancel"/> </a>
                <x-adminlte-button type="submit" theme="success" label="Update"/>
            </form>

        </div>
        <!-- /.card-body -->

        <!-- /.card-footer -->
    </div>

@endsection
@section('plugins.InputMask', true)
@section('plugins.InputFile', true)
@section('plugins.Select2', true)
@push('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@push('js')
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

    <script>
        $('input[name="date"]').daterangepicker();
        $('input[name="phone"]').inputmask('+380 (999) 999999');
        $(document).ready(function() {
            let route = '{{route('autocomplete')}}';
            autocompleteInit(route);
        });

        $(document).on('input', '#head', function () {
            let route = '{{route('autocomplete')}}';
            autocompleteInit(route);
        });

        function autocompleteInit(route) {
            $.ajax({
                method: "GET",
                url: route,
                data: {term: $('#head').val()},
                async: true,
                success: function (data) {
                    $('#head').autocomplete({
                        source: data,
                        select: function (event, ui) {
                            if (ui.item !== null) {
                                $('#hide_head').val(ui.item.value);
                                ui.item.value = ui.item.label
                            }
                        }
                    })
                }
            })
        }
    </script>
@endpush
