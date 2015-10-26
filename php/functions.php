<?php
require_once("config/db.php");
if(!isset($_SESSION)){session_start();}
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($db_connection->connect_errno)
{
	$output = array('status'=>'error','type'=>'db connection error'); ;
}
if(isset($_GET['method']))
{
	$method = $_GET['method'];

	if($method == 'addnotes')
	{
		$data = $_GET['data'];
		$stat = $_GET['status'];
		$project = $_GET['project'];
		$status = addnotes($data,$stat,$project);
		if($status != '')
			$output = array('status'=>'success','id'=>$status);
		else
		 	$output = array('status'=>'error');	
	}
	else if($method == 'ajaxloadnotes')
	{
		$name = $_GET['name'];
		$stat = $_GET['status'];
		$status = ajaxloadnotes($stat,$name);
		//loadchat($name);
		if($status)
			$output = array('status'=>'success','results'=>$status);
		else
		 	$output = array('status'=>'error');	
	}
	else if($method == 'ajaxgetprojects')
	{
		$status = ajaxgetprojects();
		if($status)
			$output = array('status'=>'success','results'=>$status);
		else
		 	$output = array('status'=>'error');	
	}
	else if($method == 'delnotes')
	{
		$id = $_GET['id'];
		$status = delnotes($id);
		if($status == 'success')
			$output = array('status'=>'success');
		else
		 	$output = array('status'=>'error');	
	}
	else if($method == 'updatenotes')
	{
		$id = $_GET['id'];
		$stat = $_GET['status'];
		$status = updatenotes($id,$stat);
		if($status == 'success')
			$output = array('status'=>'success');
		else
		 	$output = array('status'=>'error');	
	}
	else if($method == 'newproject')
	{
		$name = $_GET['name'];
		$status = newproject($name);
		if($status == 'success')
			$output = array('status'=>'success');
		else
		 	$output = array('status'=>'error');	
	}
	else if($method == 'deleteproject')
	{
		$name = $_GET['name'];
		$status = deleteproject($name);
		if($status == 'success')
			$output = array('status'=>'success');
		else
		 	$output = array('status'=>'error');	
	}
	else
	{
	 	$output = array('status'=>'error','type'=>'function not found');		
	}
	echo json_encode($output);
}

function addnotes($data,$stat,$project)
{
    $data = $GLOBALS['db_connection']->real_escape_string(strip_tags($data, ENT_QUOTES));
    $project = $GLOBALS['db_connection']->real_escape_string(strip_tags($project, ENT_QUOTES));
    $sql = "INSERT INTO notes (project_id, description, status)
	   		 VALUES((
	   		 	SELECT id 
	   		 	FROM project 
	   		 	WHERE name='" . $project . "' 
	   		 	AND user_name='" . $_SESSION['user_name'] . "')
			, '" . $data . "', '" . $stat . "');";
    $insert = $GLOBALS['db_connection']->query($sql);
    $id = $GLOBALS['db_connection']->insert_id;
	if($insert)
	{
		return $id; 
	}
}

function delnotes($id)
{
    $sql = "DELETE FROM notes 
    		WHERE id=" . $id . ";";
    $delete = $GLOBALS['db_connection']->query($sql);
	if($delete)
	{
		return 'success';
	}
}

function updatenotes($id,$stat)
{
    $sql = "UPDATE notes 
    		SET status = '" . $stat . "'
    		WHERE id ='" . $id . "';";
    $update = $GLOBALS['db_connection']->query($sql);
	if($update)
	{
		return 'success';
	}
}

function loadnotes($stat,$projectName)
{	
	$sql = "SELECT notes.id, description
	        FROM notes 
	        JOIN project ON project_id = project.id
	        WHERE notes.status = '" . $stat . "' AND project.name = '" . $projectName . "' AND project.user_name = '" . $_SESSION['user_name'] . "';";
	$notes = $GLOBALS['db_connection']->query($sql);

	foreach($notes as $note)
	{
		echo '<li class="draggable listitem" id="'.$note['id'].'" >'.$note['description'].' 
		<a href="#"class="event-close"> &#10005; </a>
		</li>';
	}
}

function ajaxloadnotes($stat,$projectName)
{	
    $stat = $GLOBALS['db_connection']->real_escape_string(strip_tags($stat, ENT_QUOTES));

	$sql = "SELECT notes.id, description
	        FROM notes 
	        JOIN project ON project_id = project.id
	        WHERE notes.status = '" . $stat . "' AND project.name = '" . $projectName . "' AND project.user_name = '" . $_SESSION['user_name'] . "';";
	$notes = $GLOBALS['db_connection']->query($sql);

	$results = array();
	foreach($notes as $note)
	{
		array_push($results, array(
			"id" => $note['id'],
			"description" => $note['description'],
			));
	}

	if($results)
	{
		return $results;
	}
}

function loadchat($projectName)
{	
  $projectName = $GLOBALS['db_connection']->real_escape_string(strip_tags($projectName, ENT_QUOTES));

  $title = $_SESSION['user_name'] . "_" . str_replace(' ', '', $projectName);

  $settings = array
  (
  // This is the message on the top of the chat (set this to false or '' to remove the top bar, defaults to 'Live chat')
  'title' => $_SESSION['user_name'] . " | " . str_replace(' ', '', $projectName),
  // Set this to true if you want to show a send button next to the message input (defaults to false)
  'view_send_btn' => true,
  'height'  =>  225
  );

  SquareLC::close_channel();
  SquareLC::channel($title);
  SquareLC::chat($settings);
}

function getprojects()
{
	$sql = "SELECT id, name
	        FROM project
	        WHERE user_name = '" . $_SESSION['user_name'] . "';";
	$projects = $GLOBALS['db_connection']->query($sql);

	foreach($projects as $project)
	{
		echo '<li><a id="project-'.$project['id'].'" name="'.$project['name'].'">'.$project['name'].'</a></li>';
	}
}

function ajaxgetprojects()
{
	$sql = "SELECT id, name
	        FROM project
	        WHERE user_name = '" . $_SESSION['user_name'] . "';";
	$projects = $GLOBALS['db_connection']->query($sql);

	$results = array();
	foreach($projects as $project)
	{
		array_push($results, array(
			"id" => $project['id'],
			"name" => $project['name'],
			));
	}

	if($results)
	{
		return $results;
	}
	// foreach($projects as $project)
	// {
	// 	echo '<li><a id="project-'.$project['id'].'" name="'.$project['name'].'">'.$project['name'].'</a></li>';
	// }
}

function newproject($name)
{
    $name = $GLOBALS['db_connection']->real_escape_string(strip_tags($name, ENT_QUOTES));
    $sql = "INSERT INTO project (name, user_name)
	    	VALUES('" . $name . "', '" . $_SESSION['user_name'] . "');";
    $insert = $GLOBALS['db_connection']->query($sql);
	if($insert)
	{
		return 'success';
	}
}

function deleteproject($name)
{
    $name = $GLOBALS['db_connection']->real_escape_string(strip_tags($name, ENT_QUOTES));
    $sql = "DELETE FROM project
    		WHERE name='" . $name . "'
    		AND user_name='" . $_SESSION['user_name'] . "';";
    $delete = $GLOBALS['db_connection']->query($sql);
	if($delete)
	{
		return 'success';
	}
}

?>