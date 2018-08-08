<html>
  <head>
<title>JQuery tests</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>

</head>
<body>

<h1>JQuery tests</h1>
<form>
Please choose but one: 
<input type="radio" name="portion_selection" value="button_one"/>
...or the other: 
<input type="radio" name="portion_selection" value="button_two"/>
  <div id="portion_one" style="display:none">
    Input the one: <input type="text" name="reference"/>
  </div>
  <div id="portion_two" style="display:none">
    Tell me the other: <input type="text" name="reference"/>
  </div>
</form>

<script type="text/javascript">
  $("input[name='portion_selection']:radio")
    .change(function() {
      $("#portion_one").toggle($(this).val() == "button_one");
      $("#portion_two").toggle($(this).val() == "button_two"); });
</script>

</body>
</html>