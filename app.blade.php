<!DOCTYPE html>
<html>
<head>
    <title>Blog System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<nav class="mb-4">
    @auth
        <a href="{{ route('posts.index') }}">Posts</a> |
        <a href="{{ route('categories.index') }}">Categories</a> |
        <a href="{{ route('logout') }}">Logout</a>
    @else
        <a href="{{ route('login') }}">Login</a> |
        <a href="{{ route('register') }}">Register</a>
    @endauth
</nav>

<div class="container">
    @yield('content')
</div>

</body>
</html>
