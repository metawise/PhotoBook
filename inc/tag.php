<?php
/*
Title: Photo Tagging
Author: Neill Horsman
URL: http://www.neillh.com.au
Credits: jQuery, imgAreaSelect 
*/

//Start session (for error reporting, can be stripped out if needed)
session_start();

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

//Include database connection details
$db_server =  'localhost'; // DB Host
$db_user =    'brizoo';    // Username
$db_pass =    'coolcool'; // Password
$db_name =    'photobook'; // DB Name

/* Connects to database system */
function db_connect(){
	global $db_server;
	global $db_user;
	global $db_pass;
	global $db_name;
	$dbcnx = mysql_connect($db_server, $db_user, $db_pass) or die("Error connecting to database: " . mysql_error());
	$dbsel = mysql_select_db($db_name, $dbcnx) or die("Error reading from database table: " . mysql_error());
}

//Connect to mysql server
db_connect();

//Set up an array to store details from database
$list_tags = Array('');

function get_results($img_location = '') {
  //Query the DB
  $qry = " SELECT id, title, x1, y1, x2, y2, width, height, img_id, img_location FROM phototags,phototags_cross WHERE img_id=id ";
  if (isset($img_location))
  {
  	$qry .= "AND img_location='".$img_location."'";
  }

  $results=mysql_query($qry) or die("Error retrieving records: " . mysql_error());

  while ($row=mysql_fetch_array($results)) {
    extract ($row);
    $name = str_replace(' ', '-', $title);
    $list_tags[] = array('id' => $id, 'title' => $title, 'name' => $name, 'x1' => $x1, 'y1' => $y1, 'width' => $width, 'height' => $height, 'img_location' => $img_location, 'img_id' => $img_id);
  }

  if(isset($list_tags))
  {
  	return $list_tags;
  }
}

//Outputting the tag styles
function get_tags($return_type = '', $img_location = '') {
	$output = '';

  //get results from DB
  $tags = get_results($img_location);

  //Do we have a return type and is $tags an array like expected
  if ($return_type != '' && is_array($tags) && $tags != '') {

    if ($return_type == 'styles') {
      $output .= '<style type="text/css">';

      $tag_counter = 1;

      //Build output
      foreach ($tags as $tag) {
        $output .= '.map a.tag_'.$tag_counter.' { ';
        //$output .= 'border:1px solid #000;';
        $output .= 'background:url(img/tag/tag_hotspot_62x62.png) no-repeat;';
        $output .= 'top:'.$tag['y1'].'px;';
        $output .= 'left:'.$tag['x1'].'px;';
        //$output .= 'width:'.$tag['width'].'px;';
        //$output .= 'height:'.$tag['height'].'px;';
        $output .= 'width:62px;';
        $output .= 'height:62px;';
        $output .= '}';
        $tag_counter++;
      }

      $output .= '</style>';
    } else if ($return_type == 'map') {

      $tag_counter = 1;

      foreach ($tags as $tag) {
        $output .= '<li><a class="tag_'.$tag_counter.'" title="'.$tag['title'].'"><span><b>'.$tag['title'].'</b></span></a></li>';
        $tag_counter++;
      }

    } else if ($return_type == 'list') {

      $title_counter = 1;

      foreach ($tags as $tag) {
        $output .= '<li><a href="#" class="title" id="tag_'.$title_counter.'">'.$tag['title'].'</a> (<a href="inc/tag.php?delete=true&amp;id='.$tag['id'].'&amp;img_location='.$img_location.'">Delete</a>)</li>';
        $title_counter++;
      }
    }
	}

	return $output;
  $output = '';
}


//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
	$str = @trim($str);
	if(get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysql_real_escape_string($str);
}

if(!empty($_POST['tag'])) {
	//Sanitize the POST values
	$title = clean($_POST['comment']);
	$x1 = clean($_POST['x1']);
	$y1 = clean($_POST['y1']);
	$w = clean($_POST['w']);
	$h = clean($_POST['h']);
	$img_id = clean($_POST['img_id']);
	$img_location = clean($_POST['img_location']);


	//Input Validations
	if($title == '') {
		$errmsg_arr[] = 'Tag title missing.';
		$errflag = true;
	}
	if($w == '' || $h == '' || $x1 == '' || $y1 == '') {
		$errmsg_arr[] = 'Area not selected';
		$errflag = true;
	}

	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: ../phototagging.php?link=".$img_location."");
		exit();
	}

	//Insert tag into databases. I am capturing more data than needed from a previous version but this could be useful oneday.
	$qry = " INSERT INTO phototags (id, title, x1, y1, x2, y2, width, height) " .
	" VALUES('', '".$title."', '".$x1."', '".$y1."', '0', '0', '".$w."', '".$h."') ";
	$result=mysql_query($qry);
	$img_id=mysql_insert_id();
	$qry2 = " INSERT INTO phototags_cross (img_id, img_location) " .
	" VALUES('".$img_id."', '".$img_location."') ";
	$result2=mysql_query($qry2);

	//Check if queries are ok
	if($result) {
		header("location: ../phototagging.php?link=".$img_location."");
	} else {
		$errmsg_arr[] = 'Something went wrong1 .'.$qry.'';
		$errflag = true;

		//If there are input validations, redirect back to the login form
		if($errflag) {
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			session_write_close();
			header("location: ../phototagging.php?link=".$img_location."");
			exit();
		}
	}
	if($result2) {
		header("location: ../phototagging.php?link=".$img_location."");
	} else {
		$errmsg_arr[] = 'Something went wrong2.'.$qry2.'';
		$errflag = true;

		//If there are input validations, redirect back to the login form
		if($errflag) {
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			session_write_close();
			header("location: ../phototagging.php?link=".$img_location."");
			exit();
		}
	}
	exit();
} else if(!empty($_GET['delete'])) {
	//Sanitize the POST values
	$img_location = clean($_GET['img_location']);
	$id = clean($_GET['id']);
	$qry = " DELETE FROM phototags where id = $id ";
	$result=mysql_query($qry);
	header("location: ../phototagging.php?link=".$img_location."");
}

?>