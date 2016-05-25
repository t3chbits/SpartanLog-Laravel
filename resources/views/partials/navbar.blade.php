<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ url('/logs') }}">Spartan Log</a>
    </div>

    <div class="collapse navbar-collapse" id="collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="{{ url('/groups') }}">Groups</a></li>
        <li><a href="{{ url('/workouts') }}">Workouts</a></li>
        <li><a href="{{ url('/exercises') }}">Exercises</a></li>
        <li><a href="{{ url('/history') }}">History</a></li>
        <li><a href="{{ url('/api') }}">API</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
      @if (Auth::check())
        <li>
          <a class="twoMin">
            <span class="glyphicon glyphicon-time"></span>
            2 Min
          </a>
        <li>
        <li>
          <a class="oneMin">
            <span class="glyphicon glyphicon-time"></span>
            1 Min
          </a>
        <li>
        <li>
          <a class="thirtySec">
            <span class="glyphicon glyphicon-time"></span>
            30 Sec
          </a>
        <li>
        <li><a href="{{ url('auth/logout') }}">Logout</a></li>
      @else
        <li><a href="{{ url('auth/login') }}">Login</a></li>
        <li><a href="{{ url('auth/register') }}">Register</a></li>
      @endif
      </ul>
    </div>
  </div>
</nav>