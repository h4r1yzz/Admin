<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Contest</h1>
    <div>
        @if(session()->has('success'))
            <div>
                {{session('success')}}
            </div>
        @endif
    </div>
    <div>
        <div>
            <a href="{{route('contests.create')}}"> Create another contest </a>
        </div>
    <table class="table table-striped table-dark" border="10">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Title_locale</th>
      <th scope="col">Contest start</th>
      <th scope="col">Contest end</th>
      <th scope="col">Contest display start</th>
      <th scope="col">Contest display end</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  @foreach($contests as $contest)
  <tbody>
    <tr>
      <td>{{$contest->id}}</td>
      <td>{{$contest->title}}</td>
      <td>{{$contest->title_locale}}</td>
      <td>
        <a href="{{route('contests.edit',['contests'=>$contest])}}"> EDIT</a>
      </td>
      <td>
        <form method="post" action="{{route('contests.delete',['contests' => $contest])}}">
            @csrf
            @method('delete')
            <input type="submit" value="Delete"/>
        </form>
      </td>

    </tr>
  </tbody>
  @endforeach
</table>
    </div>
</body>
</html>