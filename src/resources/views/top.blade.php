<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/display-booklist.js') }}" defer></script>
</head>
<body>
    <section class="w-1/4 h-screen bg-primary">
        <ul>
            <li>
                <p class="pl-6">読書中</p>
                <ul class="pl-10">
                    @foreach ($books as $book)
                        @if ($book->state==='読書中')
                            <li class="mt-2">
                                <a href="#" class="dropdown marker block">{{$book->title}}</a>
                                <ul class="pl-6 hidden dropdown__list">
                                    <li><a href="#" class="marker block">読書メモ</a></li>
                                    <li><a href="#" class="marker block">アクションリスト</a></li>
                                    <li><a href="#" class="marker block">振り返り</a></li>
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        </ul>

        <ul class="mt-10">
            <li>
                <p class="pl-6">気になる</p>
                <ul class="pl-10">
                    @foreach ($books as $book)
                        @if ($book->state==='気になる')
                            <li class="mt-2">
                                <a href="#" class="marker block">{{$book->title}}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        </ul>
    </section>


</body>
</html>
