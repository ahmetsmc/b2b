<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="POST">
    @csrf
    @php
        $test = new \App\Http\Requests\Dashboard\Products\CreateRequest();
    @endphp
    @foreach($test->rules() as $key => $rule)
        <label for="">{{ $key }} @if($errors->has($key)) (Hatalı) @endif </label>
        <input type="text" name="{{ $key }}" value="1"> @if($errors->has($key)) ({{ $errors->first($key) }}) @endif
        <br>
    @endforeach
    <button type="submit">gönder</button>
</form>
</body>
</html>
