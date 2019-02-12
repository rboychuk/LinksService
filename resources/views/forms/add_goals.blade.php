<form method="POST" action="/add_goals" class="form-inline" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input class="col-sm-4" style="margin: 10px 0 " name="file_goals"
           type="file"/>
    <button class="btn btn-default" type="submit">Add Goals</button>
</form>