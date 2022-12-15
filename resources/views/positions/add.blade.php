@extends('layouts.adminlte')
@section('title', 'Positions')

@section('myContentHeader')
    <h1>Positions</h1>
@endsection

@section('myContent')


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add new position</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form method="post" action="{{route('positions.store')}}">
                @method('post')
                @csrf
                <div class="row">
                    <x-adminlte-input name="name" label="Name position" placeholder="Name position" fgroup-class="col-md-6"  enable-old-support>
                        </x-adminlte-input>
                </div>
                <a href="{{route('positions.index')}}"> <x-adminlte-button type="button" label="Cancel"/> </a>
                <x-adminlte-button type="submit" theme="success" label="Create"/>
            </form>

        </div>
        <!-- /.card-body -->

        <!-- /.card-footer -->
    </div>

@endsection
