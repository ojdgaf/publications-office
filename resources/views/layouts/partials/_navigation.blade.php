<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">

    <div class="container-fluid">

        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Publications Office</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

          <ul class="nav navbar-nav">
            <li @yield('activePublications')><a href="/publications">Publications</a></li>
            <li @yield('activeLiterature')><a href="/literature">Literature</a></li>
            <li @yield('activeAuthors')><a href="/authors">Authors</a></li>
            <li @yield('activeDatabases')><a href="/databases">Databases</a></li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">More <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/search">Advanced search</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/about">About</a></li>
              </ul>
            </li>
          </ul>

          <form method="POST" action="{{ route('search.basic') }}" class="navbar-form navbar-left">
            <div class="form-group">
                <input type="search" name="query" class="form-control" placeholder="For example name, title or ISBN" size="30">
            </div>
            <button type="submit" class="btn btn-default">Search</button>
            {{ csrf_field() }}
          </form>

          <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
                <li @yield('activeProfile')><a href="{{ route('login') }}">Login</a></li>
                <li @yield('activeProfile')><a href="{{ route('register') }}">Register</a></li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::check() && Auth::user()->isStaff())
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Operations<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="/publications/create">Add publication</a></li>
                  <li><a href="/authors/create">Add author</a></li>
                  <li><a href="/literature/create">Add literature</a></li>
                  <li><a href="/databases/create">Add database</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="#">Exit</a></li>
                </ul>
              </li>
            @endif
          </ul>

        </div>

    </div>

</nav>
