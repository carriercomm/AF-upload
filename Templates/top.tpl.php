<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php $domain = (__DOMAIN__) ; ?>
	
    <?php require_once(__INCLUDES__ . "/stylesheets.inc.php"); ?>
	<?php require_once(__TEMPLATES__ . "/header.global.tpl.php"); ?>

	<?php $page_URL = $_SERVER["REQUEST_URI"]; 
		$url_path = parse_url($page_URL,PHP_URL_PATH);

		if ($url_path = '/account_profile'){
			if(isset($_GET["accountname"])){
				$account_value = $_GET["accountname"];
				$account_value = str_replace('_',' ',$account_value);
				echo "<title>Business Contacts for " . $account_value . "</title>";
			};
		} elseif($url_path = '/user'){
			if(isset($_GET));
		} else {
				echo "<title>Allyforce: Better Prospecting through Networking with Sales Reps </title>";
		}
	?> 
</head>

<body>

