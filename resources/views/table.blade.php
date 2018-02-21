<table id="result">
	<thead>
	 <tr>
	    <th>Coin</th>
	    <th>Rate</th>
	    <th>Encrypt</th>
	    <th>last_max_price</th>
	    <th>avg_price</th>
	    <th>avg_profit</th>
	    <th>max_24_profit</th>
	    <th>max_last_profit</th>
	    <th>max_last_profit_market</th>
  	 </tr>
   </thead>
   <tbody>
	@foreach ($results as $key)
		<tr><td>{{ $key["coin"] or '' }}</td><td>{{ $key["rate"] or '' }}</td><td>{{ $key["encrypt"] or '' }}</td><td>{{ $key["last_max_price"] or ''}}</td><td>{{ $key["avg_price"] or ''}}</td>
			<td>{{ $key["avg_profit"] or ''}}</td><td>{{ $key["max_24_profit"] or ''}}</td><td>{{ $key["max_last_profit"] or ''}}</td><td>{{ $key["max_last_profit_market"] or ''}}</td>
		</tr>
	@endforeach
	</tbody>
</table>