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

   	<p><select size="7" name="algoritm">
	@foreach ($algoritm as $a)
  	<option value={{ $a->id }}>{{ $a->name }}</option>
	@endforeach
    
   </select></p>

   <input type="number" name="numb"> HS<Br>

   	<p><select size="7" name="hash">

  	<option value=1>TH/s</option>
  	<option value=2>GH/s</option>
  	<option value=3>MH/s</option>
  	<option value=4>kH/s</option>
  	<option value=5>H/s</option>
    
    </select></p>




	
	<input type="submit" value="Сохранить">
</form>

		
</body>
</html>