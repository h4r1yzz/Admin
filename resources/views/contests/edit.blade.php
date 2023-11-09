<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Edit a contest</h1>

    <div>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
    </div>
    <form method="post" action="{{route('contests.update',['contests' => $contests ])}}">
        @csrf
        @method('put')
        <div>
            <label> Title </label>
            <input type="text" name="title" placeholder="title" value="{{$contests-> title}}"/>
        </div>
        <div>
            <label> title_locale </label>
            <input type="text" name="title_locale" placeholder="title_locale" value="{{$contests->title_locale}}"/>
        </div>
        <div>
            <label> Submit </label>
            <input type="submit" value="Update" />
        </div>
    </form>
</body>
</html>