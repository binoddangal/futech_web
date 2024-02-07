<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.default.header')
<div id="app">
    @yield('content')
    <vue-snotify></vue-snotify>
</div>
@include('layouts.default.footer')
</html>
