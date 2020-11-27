<html class="no-js" xmlns="http://www.w3.org/1999/xhtml" lang="bg" prefix="og: http://ogp.me/ns#">

<head>
    <!-- Bootstrap core CSS -->
    <link href="/media/bootstrap-4.5.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/media/style.css" rel="stylesheet">
    <meta charset="utf-8" />
    <title>PingIt</title>


    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="Check if your service is online" />
</head>

<body>
    <main role="main">

        <section class="jumbotron text-center">
            <div class="container">
                <h1>Ping<strong class="logoit">It</strong></h1>
                <p class="lead text-muted">Check if your service is online</p>

                <div class="container">
                    <div class="row">
                        <div style="margin:auto;">
                            <form class="form-inline" id="host-form" autocomplete="off">
                                <div class="form-group mb-2 ">
                                    <label for="inputHost" class="sr-only">Host</label>
                                    <input type="text" class="form-control" id="inputHost" placeholder="Host">
                                </div>
                                <button type="submit" class="btn btn-primary btn-ping mb-2">Ping</button>
                            </form>

                            <ul class="list-group">

                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="text-muted">
        <div class="container">
            <span class="text-muted">created by <a href="https://twitter.com/StanislavDakov" target="_blank">@StanislavDakov</a></span>
            <span class="text-muted float-right">open source project at <a href="https://github.com/stdakov/ping" target="_blank">github</a></span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="/media/scripts.js">
    </script>
</body>

</html>