<?php
//include db connect and seassion start.
include 'inc/tag.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PhotoBook - MyBook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- A simple css reset from yahoo -->
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.0r4/build/reset/reset-min.css" />
	<!-- Le styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      img{
      	height:inherit;
      }
    </style>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<!-- Bootstrap CSS fixes for IE6 -->
	<!--[if lt IE 7]><link rel="stylesheet" href="css/bootstrap-ie6.min.css"><![endif]-->
	<!-- Bootstrap Image Gallery styles -->
	<link rel="stylesheet" href="css/bootstrap-image-gallery.min.css">
	<!--TagCss-->
	<link rel="stylesheet" href="css/tag/tag.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
	<link rel="stylesheet" href="css/tag/imgareaselect-animated.css" type="text/css" />
	<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
	<!--[if lt IE 9]><script src="js/html5.js"></script><![endif]-->
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="img/favicon.ico">
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
    
  <!-- Outputs all tag styles, in the head for validation purposes. -->
  <?php echo get_tags('styles',$_GET['link']); ?>
  </head>

  <body>
	<?php
    //Start jquery popup error checking.
    if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
    	echo "<div id='error-box'><ul class='err'>";
    	foreach($_SESSION['ERRMSG_ARR'] as $msg) {
    		echo "<li>",$msg,"</li>"; 
    	}
    	echo "</ul><span class='closebtn'><a href='#' id='error-link'>close</a></span></div>";
    	unset($_SESSION['ERRMSG_ARR']);
    }
    //END jquery popup error checking.
    ?>
    
    <!-- Different NavBar Here -->
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="index.html">PhotoBook+</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="divider-vertical"/>
              <li><a href="mybook.php">Return to MyBook</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="page-header">
			        <h1>PhotoTagging</h1>
			    </div>
			    <h5>1. Click on the Link "Start Tagging"</h5>
			    <h5>2. Click and drag to select a zone for your tag</h5>
			    <h5>3. Write the name</h5>
			    <h5>4. Click "Submit"</h5>
			    <h6>And that's all !</h6>
			</div>
			<div class="span9">
				<div class="on-off">
			      <div class="start-tagging"><h6 style="font-weight:normal;font-size:12px">Start Tagging</h6></div>
			      <div class="finish-tagging hide"><h6 style="font-weight:normal;font-size:12px">Stop Tagging</h6></div>
			    </div>
			
			    <div class="image">
			      <div id="title_container" class="hide">
			      	<form method="post" action="inc/tag.php">
			      		<!-- Grab the X/Y/Width/Height we dont need x2 & y2, but will capture them anyway -->
			      		<fieldset>
			        		<input type="hidden" name="x1" id="x1" value="<?php echo $x1; ?>" />
			        		<input type="hidden" name="y1" id="y1" value="<?php echo $y1; ?>" />
			        		<input type="hidden" name="x2" id="x2" value="<?php echo $x2; ?>" />
			        		<input type="hidden" name="y2" id="y2" value="<?php echo $y2; ?>" />
			        		<input type="hidden" name="w" id="w" value="<?php echo $w; ?>" />
			        		<input type="hidden" name="h" id="h" value="<?php echo $h; ?>" />
			        		<input type="hidden" name="img_location" id="img_location" value="<?php echo $_GET['link']; ?>" />
			        		<label for="title" style="z-index:100;">Tag text</label><br />
			        		<input type="text" id="comment" name="comment" size="30" value="" maxlength="55" /><br />
			        		<input type="hidden" name="tag" value="true" />
			        		<input type="submit" value="Submit" class="" />
			          </fieldset>
			      	</form>
			      </div>
				  	<?php echo '<img src="'.$_GET['link'].'" id="imageid" style="" alt="Picture">';?>
				  <ul class="map">
			      	<?php echo get_tags('map',$_GET['link']); ?>
			      </ul>
		    	</div>
		    	<?php 
		    		/* Do not Display Title if there is no tag */
		    		$tagsGot=get_tags('list',$_GET['link']);
		    		if (!empty($tagsGot))
		    		{
		    			$tagtitles = '<h2 class="tagtitles">In this photo:</h2>
								    	<ul id="titles">
								      		'.$tagsGot.'
								    	</ul>';
						echo $tagtitles;
		    		}
		    	?>
		
		    <br>
		    <div class="page-footer">
		    <p>© Brice 2012</p>
		  	</div>
			</div>
		</div>
	</div>
	
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<!-- Tag script -->
	<script type="text/javascript" src="js/jquery.imgareaselect.pack.js"></script>
	<script type="text/javascript" src="js/jquery.load.js"></script>
	<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
	<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->
  </body>
</html>