<!DOCTYPE html>
<html lang="en-US">
	<head>
		<title>Ploa Blog Test</title>
		<?php
		session_start()
		?>
		<meta charset=utf-8>
		<meta name="description" content="Ploa blog demonstration">
	</head>
 	<body>
 		<h1>Blog - Write Post!</h1>
		
		<form method="post" action="./post.php">
			<label for="title">Title: </label><input name="title" id="title" type="text" placeholder="New Post Title"><br />
			<label for="text">Text: </label><input name="text" id="text" type="text" placeholder="Tell the world what you think here!"><br />
			<label for="tags">Tags: </label><input name="tags" id="tags" type="text" placeholder="Tags here (ie flowers, computers, first)"><br />
								
			<input type="submit">
		</form>
<?php

?>

	</body>
</html>
