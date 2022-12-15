@extends('layouts.adminlte')
@section('title', 'Positions')

@section('myContentHeader')
    <h1>Employees</h1>
@endsection



@section('myContent')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add new employee</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form method="post" action="{{route('employees.store')}}" enctype="multipart/form-data">
                @method('post')
                @csrf
                <x-adminlte-input-file name="image" label="Photo">

                    <x-slot name="bottomSlot">
                          <span class="text-sm text-gray">
                                  File format jpg,png up to 5 MB, the minimum size of 300x300px
                            </span>
                    </x-slot>
                </x-adminlte-input-file>



                <div class="row">
                    <x-adminlte-input name="name" label="Name" data-max="256" placeholder="Name employee" fgroup-class="col-md-6"  enable-old-support>
                    </x-adminlte-input>
                </div>
                <div class="row">
                    <x-adminlte-input name="phone" label="Phone" placeholder="Phone" fgroup-class="col-md-6"  enable-old-support>

                        <x-slot name="bottomSlot">
                          <span class="text-sm text-gray">
                                   Requeired format +380 (XX) XXX XX XX
                            </span>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="row">
                    <x-adminlte-input name="email" label="Email" placeholder="Email" type="email" fgroup-class="col-md-6"  enable-old-support>
                    </x-adminlte-input>
                </div>
                <x-adminlte-select label="Position" name="position" >
                    <x-adminlte-options :options="$select" disabled="1"
                                        empty-option="Select as position..."/>
                </x-adminlte-select>


                <div class="row">
                    <x-adminlte-input name="salary" label="Salary" type="number" placeholder="Salary" fgroup-class="col-md-6"  enable-old-support   igroup-size="sm" min=0.001 step="0.001" max=500>
                    </x-adminlte-input>
                </div>

                <div class="row">
                    <x-adminlte-input name="head" id="head" label="Head" placeholder="Head" fgroup-class="col-md-6"  enable-old-support>
                        <x-slot name="appendSlot">
                            <x-adminlte-input id="hide_head" name="hide_head" type="hidden" fgroup-class="col-md-6"  enable-old-support>
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
                <x-adminlte-date-range name="date" label="Date" igroup-size="sm" :config="$config">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-dark">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </x-slot>
                </x-adminlte-date-range>


                <a href="{{route('employees.index')}}"> <x-adminlte-button type="button" label="Cancel"/> </a>
                <x-adminlte-button type="submit" theme="success" label="Create"/>
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
