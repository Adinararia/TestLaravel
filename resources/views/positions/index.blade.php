@extends('layouts.adminlte')

@section('title', 'Positions')

@section('myContentHeader')
    <h1>Positions</h1>
    @if (session('success'))
        <div class="alert alert-success p-close" role="alert">
            {{ session('success') }}
        </div>
    @endif
@endsection

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(document).on('click', '.destroy', function(e){
            let id = $(this).data('rowid');
            let url =  'positions/showToDestroy/' +id;
            $.ajax({
                url: url,
                data: id,
                success: function (result) {
                    $('#modal-main').modal("show");
                    $('#modal-main').html(result).show();
                },
            });
        })

    </script>
@endpush

@section('myContent')
            <a href="{{ route('positions.create') }}">
    <x-adminlte-button label="Add new position"/>
            </a>
    {{ $dataTable->table() }}
@endsection

