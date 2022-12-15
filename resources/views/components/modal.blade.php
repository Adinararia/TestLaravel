<div class="modal-dialog" role="document">

    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove position {{ $name }} ?</p>
            </div>
        <form action="{{route($route, $id)}}" method="post">
            @csrf
            @method('delete')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Remove</button>
            </div>
        </form>
        </div>
</div>
