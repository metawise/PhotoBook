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
	<!--ModalCss-->
	<link rel="stylesheet" href="css/modal/reveal.css">	
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
    
  </head>

  <body>

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
              <li><a href="index.html">Home</a></li>
              <li><a href="manage.html">Manage</a></li>
              <li class="active"><a href="mybook.php">MyBook</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

	<div class="container">
	    <div class="page-header">
	        <h1>MyBook</h1>
	    </div>
	    <blockquote>
	        <p>The place where you can see your pictures.</p>
	        <p>Clic on a picture for full size and Tagging.</p>
	    </blockquote>
	    </header>
	    
		<?php
			$rep = "server/php/files/";
			$dir = opendir($rep);
			$OutModals="";
			
			while ($f = readdir($dir)) 
			{	
			   if(is_file($rep.$f) && $f!=".htaccess") 
			   {
			   	 $tab_dir[] = $f;
			   }
			}
			
			if (isset($tab_dir))
			{
				natcasesort($tab_dir);
			}
			
			echo '<ul class="thumbnails">';
			
			if (isset($tab_dir))
			{
				foreach($tab_dir as $elem)
				{
					$newName = $elem;
					$newName = strtolower($newName);
					$newName = preg_replace("/ /", "-", $newName);
					$newName = str_replace(".", "-", $newName);
					
					echo '<li class="span2">';
					echo  '<a href="phototagging.php?link='.$rep.$elem.'" class="thumbnail" style="min-height:110px;"><img id="img" title="'.$elem.'" src="'.str_replace("files", "thumbnails", $rep).$elem.'" alt="'.$elem.'" style="max-height:110px;max-width:160px;"></a>';
					echo '</li>';
					
					/*
	$OutModals .= '<div id="'.$newName.'" class="reveal-modal">
							<h1>'.$elem.'</h1>
							<p><img src="'.$rep.$elem.'" style="" alt="'.$elem.'"></p>
							<a class="close-reveal-modal">&#215;</a>
						  </div>';
	*/
		    	}
		    	echo '</ul>';
		    	/*
	echo '<div id="ModalDivs">';
		    	echo $OutModals;
		    	echo '</div>';
	*/
			}
	    	?>
	    	
	    
	    <br>
	    <div class="page-footer">
	    <p>© Brice 2012</p>
	  	</div>
	</div>
	
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<!-- Modal Script -->
	
	<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
	<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->
  </body>
</html>