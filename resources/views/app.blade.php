<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spartan Weight Lifting Log</title>

    <link rel="stylesheet" href="{!! asset('bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('select2/css/select2.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/all.css') !!}">
</head>

<body>

  @include('partials.navbar')

  <div class="container-fluid">
    @yield('content')
  </div>

  <script type="text/javascript" src="{!! asset('jquery/jquery.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('bootstrap/js/bootstrap.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>

  <!-- In history.blade.php, exerciseCharts.js and chart.js are included here -->
  <!-- In workout/showOne.blade.php and group/showOne.blade.php, select2.js is included here -->
  @yield('footer') 
</body>
</html>