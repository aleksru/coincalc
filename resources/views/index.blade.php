<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{{ $title or '' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="js/query.js"></script>

</head>

<body>
	<h1>{{ $msg or ' ' }}</h1>

<form action="postindex" method="post">
	{{ csrf_field() }}

	<p><select size="7" name="videocart">
	@foreach ($videocard as $card)
  	<option value={{ $card->id }}>{{ $card->name }}</option>
	@endforeach
    
   </select></p>


    @foreach ($algoritm as $a)
      {{$a->algname}}<Br>
    <input type="number" name= algenc/{{ $a->algid }}/{{ $a->encid }} value=''>{{$a->encname}}<Br><Br>
    @endforeach

    <input type="submit">

</form>

<div id='res'></div>

		
</body>
</html>