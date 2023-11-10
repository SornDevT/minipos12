<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('assets/vendor/css/core.css') }}" class="template-customizer-core-css">
    <link rel="stylesheet" href="{{ url('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css">
    <link rel="stylesheet" href="{{ url('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/font_lao.css') }}">

    @vite('resources/css/app.css')
</head>
<body>

    <div id="app-vue"></div>

    <script src="{{ url('assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ url('assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ url('assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    @vite('resources/js/app.js')
</body>
</html>