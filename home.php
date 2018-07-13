<?php
session_start();
require_once("lib3.php");
require_once("includes/header.php");
require_once("includes/footer.php");

if(!isUserLoggedIn()){
    header("Location : login.php");
    exit;
}

    // get reports
    $success=1;
    $results = "";
    if(isset($_POST["searchBtn"])){
        if($_POST["phrase"]!=""){
            $results = getSearchedAssets($_POST["phrase"]);
        }
            
            $success = 0;  
    }
    // set new url key for form on key page

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>CCA</title>
    <?php css(); ?>
</head>
<body>
    <div class="topnav">
    <nav class="navbar navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
          <img src="assets/img/cca_logo.jpg" />
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            <p class="navbar-brand" id="big-text"></p>

          <div class="nav navbar-nav navbar-right" id="logout">
            <a class="btn btn-danger" href="logout.php">Logout</a>
          </div>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
        
    </div>

    <div class="container">

        <div class="page-header">

            <div class="row">

                <div class="col-lg-4 col-md-4">

                    <!-- Querry data from the database -->
                    
                        <form method="POST" role="form">
                            
                            <div class="form-group">

                                <div class="form-group">
                                    <input id="search" class="form-control" type="text" name="phrase" placeholder="Enter search value" required>
                                </div>

                                <div class="form-group">
                                    <input  type="submit" class="btn btn-success" name="searchBtn" value="Search">
                                </div>
                           
                                
                            </div>
                        
                        </form>                 

                </div>


                <div class="col-lg-4 col-md-4">
                   
                    <!-- search with radio buttons -->
                     <div class="form-group">
                        <label>Content Type</label>

                            <div class="radio">
                                <input class="customRadioButton" id="all" type="radio" name="searchRadio" value="" checked>
                                <label for="all">All</label>
                            </div>
                            <div class="radio">
                                <input class="customRadioButton" id="audio" type="radio" name="searchRadio" value="Audio">
                                <label for="audio">Audio</label>
                            </div>
                            <div class="radio">
                                <input class="customRadioButton" id="video" type="radio" name="searchRadio" value="Video">
                                <label for="video">Video</label>
                            </div>

                    </div>
                </div>

                <div class="col-lg-4 col-md-4">

                    <!-- Search with dates -->
                    <!-- <div class="form-group">
                        <label class="control-label">Creation Date</label>
                        <div class="input-group date">
                            <input type="text" class="form-control" placeholder="Select a start date" id="start-date" name="start-date"><span class="input-group-addon"><i class="icon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">End Creation Date</label>
                        <div class="input-group date">
                            <input type="text" class="form-control" placeholder="Select a end date" id="end-date" name="end-date"><span class="input-group-addon"><i class="icon-calendar"></i></span>
                        </div>
                    </div> -->
                
                </div>


                <div class="col-lg-12 col-md-12 display-result">
               
                    <table id="example" class="table table-oddEven-rows table-hover table-striped table-fixed-row-heights dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Asset Id</th>
                                <th>Asset Type</th>
                                <th>File Name</th>
                                <th>Creation Date</th>
                                <th>Tag</th>
                                <th>Artist</th>
                                <th>Country</th>
                                <th>Genera</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php 
                            if($results!=""){
                                foreach($results as $data) {
                                   $metadata = explode(',',$data['data']);
                                    ?>
                            <tr>
                                <td>
                                    <?php echo $data['id']; ?>
                                </td>
                                <td>
                                    <?php echo $data['type']; ?>
                                </td>
                                <td>
                                    <?php echo $data['filename']; ?>
                                </td>
                                <td>
                                    <?php echo $data['creationDate']; ?>
                                </td>
                                <td>
                                    <?php echo $metadata[0]; ?>
                                </td>
                                <td>
                                    <?php echo $metadata[1]; ?>
                                </td>
                                <td>
                                    <?php echo $metadata[2]; ?>
                                </td>
                                <td>
                                    <?php echo $metadata[3]; ?>
                                </td>
                            </tr>
                            <?php }} ?>

                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Asset Id</th>
                                <th>Asset Type</th>
                                <th>File Name</th>
                                <th>Creation Date</th>
                                <th>Tag</th>
                                <th>Artist</th>
                                <th>Country</th>
                                <th>Genera</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>

<?php loadjs(); ?>
 
</body>
</html>
