<select class="custom-select" name="school_year" required>
	<option selected>During</option>
	@for ($i = 10; $i < substr(date("Y"), 2); $i++)
		<option value="{{$i}}" {{ $i == old("school_year", Request::get('school_year'))?"selected":""}}>{{$i}}/{{$i+1}}</option>
	@endfor
</select>