<!DOCTYPE html>
<html lang="en-US">
	<head>
		<title>Ploa Blog Test</title>
		<meta charset=utf-8>
		<meta name="description" content="Ploa blog demonstration">
		<link rel=StyleSheet href="styles/global.css" type="text/css">
		<link rel=StyleSheet href="styles/writer.css" type="text/css">
	</head>
 	<body>
 	<div id="sitewrapper">
 		<h1>ploa - Write Post!</h1>
		
		<fieldset>
	    <legend>Create a new post</legend>
		        <form method="post" action="./post.php">
			        <label for="title">Title </label><input name="title" id="title" type="text" class="title" placeholder="New Post Title">
			        <label for="tags">Tags </label><input name="tags" id="tags" type="text" class="tags"  placeholder="Tags here (ie flowers, computers, first)"><br />
			        <div class="separater"></div>
			        <textarea name="text" id="text" type="text" class="text" placeholder="Tell the world what you think here!"></textarea><br />
			        <div class="inputs"><input type="submit" value="Save Post"  class="button"></input></div>
					<div class="inputs"> <input type="checkbox" name="status" id="status" value=1 checked="checked" class="checkbox"><label for="status" >Publish Post </label></div>	
		        </form>
        </fieldset>
    </div>
	</body>
</html>
