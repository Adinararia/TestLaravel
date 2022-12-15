@extends('layouts.adminlte')
@section('title', 'Positions')

@section('myContentHeader')
    <h1>Positions</h1>
@endsection

@section('myContent')


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit position - {{$position->name}}</h3>
        </div>
        <!-- /.card-header -->
        <form method="post" action="{{route('positions.update', $position->id)}}">

        <div class="card-body">
                @method('PATCH')
                @csrf
                <div class="row">
                    <x-adminlte-input value="{{$position->name}}" size="256" name="name" label="Name position" placeholder="Name position" fgroup-class="col-md-6"  enable-old-support/>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user text-lightblue"></i>
                        </div>
                    </x-slot>
                </div>

            <div class="row">
                <p style="margin-right: 50px"><b>Created at:</b> {{$position->created_at}} </p>
             <p><b>Admin created ID:</b> {{$position->admin_created_id}} </p>

            </div>
            <div class="row">
                <p style="margin-right: 50px"><b>Updated at:</b> {{$position->updated_at}}</p>
               <p><b>Admin updated ID:</b> {{$position->admin_updated_id}}</p>
            </div>
                <a href="{{route('positions.index')}}"> <x-adminlte-button type="button" label="Cancel"/> </a>
                <x-adminlte-button type="submit" theme="success" label="Update"/>
        </div>
        <!-- /.card-body -->
        <!-- /.card-footer -->
        </form>

    </div>

@endsection
