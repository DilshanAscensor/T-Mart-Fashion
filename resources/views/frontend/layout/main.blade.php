<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>T MART Fashion | {{ $titlePage ?? '' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-S..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <style>
        div:where(.swal2-container).swal2-center>.swal2-popup {
            width: 400px;
            border-radius: 15px;
            background: #0d0d0e;
        }

        div:where(.swal2-icon) {
            width: 4em;
            height: 4em;
        }

        div:where(.swal2-icon).swal2-error [class^=swal2-x-mark-line] {
            top: 1.8em;
            width: 1.9375em;
        }
    </style>
</head>

<body>

    <div>
        @include('frontend.layout.includes.navbar')

        <main class="content pt-5">
            @yield('content')
        </main>

        @include('frontend.layout.includes.footer')

    </div>

</body>


</html>
