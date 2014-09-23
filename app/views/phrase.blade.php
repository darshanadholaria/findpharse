<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        <title>Phrase - Laravel</title>

        {{ HTML::style('css/bootstrap.min.css')}}
    </head>

    <body>

        <div class="container">
            <!-- Example row of columns -->
            <h2>Phrase Found.</h2>
            <hr>
            <div class="row">
                <ol>
                    @foreach ($phrase as $key => $value)
                        <li class="col-sm-4">{{ $key }} ( {{ $value }} )</li>

                    @endforeach
                </ol>
            </div

        </div> <!-- /container -->

        {{ HTML::script('js/jquery.min.js')}}
        {{ HTML::script('js/bootstrap.min.js')}}
    </body>
</html>
