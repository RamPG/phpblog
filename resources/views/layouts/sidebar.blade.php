<div class="col-md-4">
    <div class="card my-4">
        <h5 class="card-header">Поиск по статьям</h5>
        <div class="card-body">
            <form class="input-group" method="post" action="{{ route('post.search') }}">
                @csrf
                <input type="text" class="form-control" name="text" id="text" placeholder="Искать...">
                <span class="input-group-append">
                <button class="btn btn-secondary" type="submit">Найти!</button>
              </span>
            </form>
        </div>
    </div>
</div>
