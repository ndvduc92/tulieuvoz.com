<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta name="viewport" 
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta charset="utf-8" />
    <meta name="google-site-verification" content="C4X4J2ptzpxLpEuslrHYjlm5X_8ldSCwRmhrjpO1Rt4" />
    <meta name="description" content="Make Voz Great Again">
    <meta name="keywords" content="voz, vozer, tư liệu voz, tư liệu vozer, decode hex, convert hex to text, hex to text, text to hex, encode text, convert text to hex" itemprop="keywords"/>
    <meta name="news_keywords" content="voz, vozer, tư liệu voz, tư liệu vozer, decode hex, convert hex to text, hex to text, text to hex, encode text, convert text to hex" />
    <link rel="icon" type="image/png" href="/assets/images/voz-favicon.png" sizes="32x32" />
    <title>Make Voz Great Again</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script data-ad-client="ca-pub-1950385934224342" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

    <script src="/assets/js/copy.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

  </head>
  <body>
    <div id="app">
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button
              type="button"
              class="navbar-toggle collapsed"
              data-toggle="collapse"
              data-target="#bs-example-navbar-collapse-1"
              aria-expanded="false"
            >
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"
              ><img src="/assets/images/voz-logo.png" width="60%" alt=""
            /></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="active">
                <a
                  href="https://www.facebook.com/groups/khongcochuyenchungtoibangroup"
                  target="_blank"
                  >Make VOZ Great Again <span class="sr-only">(current)</span></a
                >
              </li>
              <li>
                <a href="/links">Bộ sưu tập</a>
              </li>
              @if (Auth::check())
              <li>

<a href="/manage">Quản lý link ({{ Auth::user()->name }})</a>
</li>
              <li>
              <li>

<a href="/likes">Danh sách yêu thích</a>
</li>
              <li>

<a href="/logout">Đăng xuất</a>
</li>
                    @else
                    <li>
                    <a href="/login">Đăng Nhập</a>
                    </li>
                    @endif

            </ul>
          </div>
          <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
      </nav>

      <div class="container">
        @yield('content')
      </div>
    </div>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9NCTX44NS3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-9NCTX44NS3');
    </script>
  </body>
</html>
