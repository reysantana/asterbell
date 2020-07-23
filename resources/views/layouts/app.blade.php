<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    
    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand navbar-dark bg-info mb-4">
          <a class="navbar-brand" href="{{ url('/projects') }}">Asterbell</a>
          @guest
          @else
          @if(Auth::user()->type == '1')
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
<!--               <li class="nav-item{{ Request::segment(1) === 'projects' ? ' active' : null }}">
                <a class="nav-link" href="{{ url('/projects') }}">Projects</a>
              </li>
              <li class="nav-item{{ Request::segment(1) === 'luckydraws' ? ' active' : null }}">
                <a class="nav-link" href="{{ url('/luckydraws') }}">Lucky Draws</a>
              </li> -->
              <li class="nav-item{{ Request::segment(1) === 'argames' ? ' active' : null }}">
                <a class="nav-link" href="{{ url('/argames') }}">AR Games</a>
              </li>
<!--               <li class="nav-item{{ Request::segment(1) === 'vouchers' ? ' active' : null }}">
                <a class="nav-link" href="{{ url('/vouchers') }}">Vouchers</a>
              </li>
              <li class="nav-item{{ Request::segment(1) === 'adsbanners' ? ' active' : null }}">
                <a class="nav-link" href="{{ url('/adsbanners') }}">Ads Banners</a>
              </li>
              <li class="nav-item{{ Request::segment(1) === 'survey-feedbacks' ? ' active' : null }}">
                <a class="nav-link" href="{{ url('/survey-feedbacks') }}">Survey Feedbacks</a>
              </li> -->
              <li class="nav-item{{ Request::segment(1) === 'users' ? ' active' : null }}">
                <a class="nav-link" href="{{ url('/users') }}">Users</a>
              </li>
<!--               <li class="nav-item dropdown{{ Request::segment(1) === 'settings' ? ' active' : null }}">
                <a class="nav-link dropdown-toggle" href="#" id="menuSettings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Settings
                </a>
                <div class="dropdown-menu" aria-labelledby="menuSettings">
                  <a class="dropdown-item" href="{{ url('/settings/notification-templates') }}">Notification Templates</a>
                </div>
              </li> -->
            </ul>
          </div>
          @endif
<!--           @if(Auth::user()->email == 'topmedia@e-intro.com.my')
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
              <li class="nav-item{{ Request::segment(1) === 'argames' ? ' active' : null }}">
                <a class="nav-link" href="{{ url('/leaderboard/grab-the-treasure') }}">Leaderboard</a>
              </li>
            </ul>
          </div>
          @endif -->
          <div>
            <button type="button" class="btn btn-dark btn-sm" onclick="document.getElementById('logout-form').submit();">Logout</button>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </div>
          
          @endguest
        </nav>

        <div id="main-content" class="mb-4">@yield('content')</div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
