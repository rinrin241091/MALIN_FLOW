<base href="{{env('APP_URL')}}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MALIN FLOW | Dashboard </title>

<!-- CSS -->
<link href="backend/css/bootstrap.min.css" rel="stylesheet">
<link href="backend/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="backend/css/animate.css" rel="stylesheet">
<link href="backend/css/style.css" rel="stylesheet">
<link href="backend/css/customize.css" rel="stylesheet">

@if(isset($config['css']) && is_array($config['css']))
    @foreach($config['css'] as $key => $val)
        {!! '<link rel="stylesheet" href="'.$val.'"></script>' !!}
    @endforeach
@endif