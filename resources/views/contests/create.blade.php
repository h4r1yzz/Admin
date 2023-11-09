<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Create a contest</h1>

    <div>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
    </div>
    <form method="post" action="{{route('contests.store')}}">
        @csrf
        @method('post')
        <div>
            <label> Title </label>
            <input type="text" name="title" placeholder="title"/>
        </div>
        <div>
            <label> title_locale </label>
            <input type="text" name="title_locale" placeholder="title_locale"/>
        </div>
        <div>
            <label> contest start </label>
            <input type="date" name="title_locale" placeholder="title_locale"/>
        </div>
        <div>
            <label> contest end </label>
            <input type="date" name="title_locale" placeholder="title_locale"/>
        </div>
        <div>
            <label> contest display start </label>
            <input type="date" name="title_locale" placeholder="title_locale"/>
        </div>
        <div>
            <label> contest display end </label>
            <input type="date" name="title_locale" placeholder="title_locale"/>
        </div>
        
        <div>
            <label> Submit </label>
            <input type="submit" value="Save a new contest"/>
        </div>
    </form>
</body>
</html>