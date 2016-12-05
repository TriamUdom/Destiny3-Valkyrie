<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">ระบบตรวจสอบการสมัคร โรงเรียนเตรียมอุดมศึกษา @if(Config::get('app.debug') === true) <sup><span class="badge"><i class="fa fa-crosshairs"></i> Debug Mode</span></sup> @endif</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

      </ul>
      @if(Session::has('admin_logged_in'))
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user text-muted"></i> {{ Session::get('admin_name') }}, {{ Session::get('supervisor_name') }}<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/logout"><i class="fa fa-sign-out"></i> ออกจากระบบ</a></li>
          </ul>
        </li>
      </ul>
      @endif
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>
