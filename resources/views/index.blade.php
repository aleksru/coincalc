<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <link href="css/style.css" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{{ $title or '' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="js/query.js"></script>
 <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>


</head>

<body>
	<h1>{{ $msg or ' ' }}</h1>

   <div class="videocart">
    <form action="gethash" method="post" id="videocart" name="videocart">
    @foreach ($videocard as $card)
    <table class=enc>
      <tr><th>{{ $card->name }}</th></tr>
      <tr><td><input type="number" min=0  name={{ $card->id }} ></td></tr> 
    </table>
    @endforeach
    </form>
   </div><br clear="left"><br clear="left">

<form action="postindex" method="post" id="postindex">
	{{ csrf_field() }}
   <div class="encrypt">
    @foreach ($algoritm as $a)
    <table class=enc>
     <tr><th>{{$a->algname}}</th></tr>
     <tr><td><input type="number" step="any" class={{ $a->algid }} name= algenc/{{ $a->algid }}/{{ $a->encid }} value=''>{{$a->encname}}</td></tr>
   </table>
    @endforeach
  <br clear="left">
  </div>
  <div id="100">
  <input type="submit" id="btn" style="width:250px; height: 60px; clear:both;"> 
  </div>
</form>

<br/>
<div id="load"><img src="../public/picture/loading.gif" width="200px"> </div>

<br/>
<div id="res"></div>

		
</body>
</html>