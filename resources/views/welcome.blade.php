<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Погода</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Погода</h1>

    <form action="" method="post">
        @csrf
        <div class="form-group">
            <label>Дата</label>
            <input type="text" placeholder="Введите дату" class="form-control {{ $errors->has('date') ? 'error' : '' }}" name="date" id="date" value="{{ old('date', $post['date'] ?? '') }}">

            @if ($errors->has('date'))
                <div class="error">
                    {{ $errors->first('date') }}
                </div>
            @endif
        </div>

        <input type="submit" name="send" value="Поиск" class="btn btn-dark btn-block">
    </form>

    @if (!empty($result))
        <div class="message">
            Температура {{ $result['temp'] }} градусов
        </div>
    @endif
    <hr>

    <h3>История за последние 30 дней</h3>

    @foreach($history as $record)
        <p>{{ $record['date_at'] }} - {{ $record['temp'] }} градусов</p>
    @endforeach
</div>

</body>
</html>