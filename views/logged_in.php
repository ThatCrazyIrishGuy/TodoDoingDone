<!-- if you need user information, just put them into the $_SESSION variable and output them here -->
<!-- Hey, <?php echo $_SESSION['user_name']; ?>. You are logged in.
Try to close this browser tab and open it again. Still logged in! ;) -->
<!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->
<!-- <a href="index.php?logout">Logout</a> -->
<?php include("functions.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="images/favicon.html">
<title>ToDo Doing Done!</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-reset.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>
<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Todo Doing Done</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Project <b class="caret"></b></a>
                <ul class="dropdown-menu" id="projects-dropdown">
                    <?php getprojects(); ?>         
                </ul>
            </li>
            <li><a href="" data-toggle="modal" data-target="#new-project">New Project</a></li>
            <li><a href="" data-toggle="modal" data-target="#delete-project">Delete Project</a></li>
            <li><a href="index.php?logout">Logout</a></li>       
        </ul>

        <!-- New Project Modal -->
        <div class="modal fade" id="new-project" tabindex="-1" role="dialog" aria-labelledby="newProject" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newProjectModalLabel">New Project</h4>
              </div>
              <div class="modal-body">
                 <div class="input-group">
                 <input type="text" class="form-control" id="create-project-input" placeholder="Project Name (Max 255 Characters)" aria-describedby="sizing-addon2">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" id="create-project-button">Create Project</button>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Delete Project Modal -->
        <div class="modal fade" id="delete-project" tabindex="-1" role="dialog" aria-labelledby="deleteProject" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newProjectModalLabel">Delete Project</h4>
              </div>
              <div class="modal-body">
                <h5>Are you sure you want to delete this project, this is irreversible!</h1>
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" id="delete-project-button">Delete Project</button>
                </div>
              </div>
            </div>
          </div>

        <div class="col-sm-3 col-md-3 pull-right">
            <form class="navbar-form" role="search">
                <div class="input-group">
                    <input class="form-control" id="search" name="search" placeholder="Search Notes" type="text" data-toggle="hideseek" data-list=".event-list" autocomplete="off">
                </div>
            </form>
        </div>        
    </div>
</nav>
<body>
<div class="cal-day"><center id="displayed-project-name">default</center></div>
<input type="hidden" value="default" id="project-name">
<div class="col-md-4 ">
  <div class="col-md-10 col-md-offset-1 event-list-block todo">
    <div class="cal-day">
      <center>ToDo</center>
    </div>
    <ul class="todo-list event-list" name="todo-list">
      <?php loadnotes('todo','default');?>
    </ul>
    <input type="text" class="form-control todo-input evnt-input" placeholder="NOTES">
  </div>
</div>
<div class="col-md-4 ">
  <div class="col-md-10 col-md-offset-1 event-list-block doing">
    <div class="cal-day">
      <center>Doing</center>
    </div>
    <ul class="doing-list event-list" name="doing-list">
      <?php loadnotes('doing','default'); ?>
    </ul>
    <input type="text" class="form-control doing-input evnt-input" placeholder="NOTES">
  </div>
</div>
<div class="col-md-4 ">
  <div class="col-md-10 col-md-offset-1 event-list-block done">
    <div class="cal-day">
      <center>Done</center>
    </div>
    <ul class="done-list event-list" name="done-list">
      <?php loadnotes('done','default'); ?>
    </ul>
    <input type="text" class="form-control done-input evnt-input" placeholder="NOTES">
  </div>
</div>
<div class="col-md-6 col-md-offset-3" id="chat-container">
</div>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/vendor/jquery.hideseek.min.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/jquery.ui.touch-punch.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
