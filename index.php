<?php

require_once('config.php');
require_once('todo.class.php'); 

$list = new ToDo();
$list->add();
$list->save_to_file();
       
?>
        
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Todo List</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    </head>
    
    <body>

        <h1>Todo List - Web App</h1>
		
		<div id="list_container">
			<ol>		       
				<?php
					$current_list = $list->display();

	        		foreach($current_list as $item) {
	        			echo "<li>". $item['todoitem'] ."</li>";
	        		}
				?>
			</ol>
		</div>

        <h1>Entry</h1>

        <form action="./" method="post">
			<input name="note" type="text" placeholder="Add Note" id="note">
			<input type="submit" value="Add" id="add_note">
		</form>

    </body>
</html>