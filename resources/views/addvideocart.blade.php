<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{{ $title or '' }}</title>

</head>

<body>
	<h1>{{ $msg or ' ' }}</h1>

<form action="addvideo" method="post">
	{{ csrf_field() }}

	<p><select size="7" name="videocart">
	@foreach ($videocard as $card)
  	<option value={{ $card->id }}>{{ $card->name }}</option>
	@endforeach
    
   </select></p>

  <div class="encrypt">
    @foreach ($algoritm as $a)
    <table class=enc>
     <tr><th>{{$a->algname}}</th></tr>
     <tr><td><input type="number" step="any" class={{ $a->algid }} name= algenc/{{ $a->algid }}/{{ $a->encid }} value=''>{{$a->encname}}</td></tr>
   </table>
    @endforeach
  <br clear="left">
  </div>

	<input type="submit" value="Сохранить">
</form>

		
</body>
</html>