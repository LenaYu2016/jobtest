<html>
<head>
    <meta name="csrf_token" content="{!! csrf_token() !!}"/>
    <link type="text/css" rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css"/>
</head>
<body>
<div class="container">
    <h1>Business Risk Form Search</h1>
  <form action="#" method="post" id="myform" >
    <input type="hidden" id="token" name="_token" value="{{csrf_token() }}">
    <div class="form-group">

            <input list="heroes" type="text" id="searchBar" name="types" class="form-control">
            <datalist id="heroes">
                @foreach($types as $type)
                    <option value="{{$type->type_name}}">
                @endforeach
            </datalist>

    </div>

    <div class="form-group">

            <button type="submit" name="submit" class="btn btn-primary">Search</button>


    </div>
  </form>
    <div id="second">

    </div>
    <div id="forms"></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="../resources/assets/js/index.js"></script>
</body>
</html>