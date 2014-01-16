<?php 

/*
 * To Do List
 *
 * @author		Mark Cotton
 * @copyright	Copyright (c) 2014 - Mark Cotton
 * @link		http://www.markcotton.co.uk
 * @since		Version 1.0
 *
 */

require_once('dbconfig.php');

class Todo {	
	
	private $note; 
	private $db;

	function __construct() {

		global $db_host, $db_name, $db_port, $db_user, $db_pass;

		// Establish database connection
		try {
			$this->db = new PDO("mysql:host=$db_host;dbname=$db_name;port=$db_port", "$db_user", "$db_pass");
			
			// Set error mode
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

			// Define the character set
			$this->db->exec("SET NAMES 'utf8'");
		} catch(Exception $e) {
			echo "<p>Could not connect to the database. Information on error:</p><p>" . $e . "</p>";
			exit;
		}
		
		// Check if the todo list table exists, if not create it
		$table_exists = $this->db->query('SHOW TABLES LIKE "todo_list"')->rowCount();
		
		if(!$table_exists) {
			$this->db->query('CREATE TABLE todo_list (
				id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				todoitem TEXT,
				tododate DATE NOT NULL
			) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB');
		}

		// Get any submitted notes
		$this->note = isset($_POST['note']) ? htmlspecialchars(htmlentities($_POST['note'])) : 'NULL';

	}
	
	/**
	 * 
	 *	Add
	 *
	 *	Adds a note to the database. 
	 *
	 */	
	function add() {		
		$date = date('Y-m-d');
		
		$this->db->query('INSERT INTO todo_list SET todoitem = "'. $this->note .'", tododate = '. $date .'');
	}

	/**
	 * 
	 *	Remove
	 *
	 *	Remove a note from the database. 
	 *
	 */	
	function remove($element_id) {
		$this->db->query('DELETE FROM todo_list WHERE id = "'. $element_id .'"');
	}
	
	/**
	 * 
	 *	Display
	 *
	 *	Displays the todo list
	 *
	 */	
	function display() {
		$current_list = $this->db->query('SELECT todoitem FROM todo_list WHERE id');
		
		return $current_list; 
	}
	
	/**
	 * 
	 *	Save to file
	 *
	 *	Save the todo list to a text file
	 *
	 */	
	function save_to_file() {
		$todo_list = fopen("todo.txt","a") or exit("Error: Unable to open file.");
		
		$check = 0;
				
		$this->note .= "\n";
			
		if(fwrite($todo_list, $this->note) !== FALSE) {
			$check++;		
		}
		
		if($check > 0) {
			echo "File has been saved.";
			fclose($todo_list);
		}
	}
	
}