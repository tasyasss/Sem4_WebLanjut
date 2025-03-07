<!-- View pada resources/views/hello.blade.php -->
<html>

<body>
    <h1>Hello, {{ $name }}</h1>
    {{-- <p>(dalam direktori views/blog)</p> --}}

    {{-- Meneruskan data ke view --}}
    <h1>You are {{ $occupation }}</h1>
</body>

</html>
