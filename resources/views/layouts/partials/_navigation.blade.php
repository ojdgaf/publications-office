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
                <li><a href="#">Report an issue</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>

          <form method="POST" action="{{ route('search.basic') }}" class="navbar-form navbar-left">
            <div class="form-group">
                <input type="search" name="query" class="form-control" placeholder="For example name, title or ISBN/ISSN" size="30">
            </div>
            <button type="submit" class="btn btn-default">Search</button>
            {{ csrf_field() }}
          </form>

          <ul class="nav navbar-nav navbar-right">
            <li @yield('activeProfile')><a href="/profile">Profile</a></li>
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
          </ul>

        </div>

    </div>

</nav>
