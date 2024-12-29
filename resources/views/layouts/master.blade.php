<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ConnectFriend</title>
    @include('customs.bootstrap5css')
    @include('customs.fontawesome')

</head>

<body>

    @include('components.navbar')

    <div class="p-4 bg-secondary">
        <div class="mx-auto px-4" style="max-width: 1200px; min-height: 90vh;">
            @yield('content')
        </div>
    </div>

    @include('components.footer')

    @include('customs.bootstrap5js')

    @yield('scripts')
</body>

</html>
