<html>
<head>
<title> Test Page </title>
<script src="ajax/prototype1.7.js" type="text/javascript"></script>
<tbody>
<script>
function test$$(){
	/*
	  in case CSS is not your forte, the expression below says
	  'find all the INPUT elements that are inside
	  elements with class=field that are inside a DIV
	  with id equal to loginForm.'
	*/
	var f = $$('div#loginForm #nameUser');
        f.toggle();
	var s = '';
	for(var i=0; i<f.length; i++){
		s += f[i].value + '/';
	}
	alert(s); // shows: "joedoe1/secret/"

	//now passing more than one expression
	f = $$('div#loginForm .field input', 'div#loginForm .fieldName');
	s = '';
	for(var i=0; i<f.length; i++){
		s += ( f[i].value ? f[i].value : f[i].innerHTML ) + '/';
	}
	alert(s); //shows: "joedoe1/secret/User name:/Password:/"
}


</script>

<div id='loginForm'>
    <div class='field' id="name">
        <span class='fieldName'id="nameUser">NOmbre del Usuarioa:</span>
		<input type='text' id='txtName' value='joedoe1'/>
	</div>
	<div class='field'>
		<span class='fieldName'>Password:</span>
		<input type='password' id='txtPass' value='secret' />
	</div>
	<input type='submit' value='login' />
</div>
<input type=button value='test $$()' onclick='test$$();' />
<script>
	function test3()
	{
		alert(  $F('userName')  );
	}
</script>

<input type="text" id="userName" value="Joe Doe"><br/>
<input type="button" value="Test3" onclick="test3();"><br/>


</body>
</html>
