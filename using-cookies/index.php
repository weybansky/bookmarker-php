<?php
	$cookie_name 	= "bookmarks-with-php";
	$cookie_value 	= "all bookmarks are stored in array value-pairs";
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
	if(count($_COOKIE) < 1) {
	    echo "Cookies are disabled.";
	    die();
	}


	if (isset($_POST['submit']) && !empty($_POST['title'])) {
		$title = strval($_POST['title']);
		$cookie_name 	= "bookmarks[$title]";
		$cookie_value 	= $_POST['link'];
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
		header('location:index.php');
	}
	

	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'delete') {
			$title = strval($_GET['title']);
			$cookie_name 	= "bookmarks[$title]";
			setcookie($cookie_name, "", time() - (86400 * 30), "/");
			header('location:index.php');
		}
		
		if ($_GET['action'] == 'clearall') {
			foreach ($_COOKIE['bookmarks'] as $title => $link) {
				$cookie_name 	= "bookmarks[$title]";
				setcookie($cookie_name, "", time() - (86400 * 30), "/");
			}
			header('location:index.php');
		} 
	}
	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Bookmarker</title>
	<link rel="stylesheet" href="https://bootswatch.com/3/cyborg/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>

	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">Brand</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="?action=clearall">Clear</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" class="form-control" name="title">
					</div>
					<div class="form-group">
						<label for="link">Link</label>
						<input type="url" class="form-control" name="link">
					</div>
					<div class="form-group">
						<button class="form-control btn btn-warning" name="submit" type="submit">Add to Bookmark</button>
					</div>
				</form>
			</div>
			<div class="col-md-6 col-sm-6">
				<?php if(isset($_COOKIE['bookmarks'])): ?>
				<p>Bookmarks</p>
				<ul class="list-group">
					<?php foreach($_COOKIE['bookmarks'] as $title => $link): ?>
						<li class="list-group-item">
							<a href="<?= $link; ?>">
								<?= $title; ?>
									<a href="?action=delete&title=<?= $title; ?>" class="pull-right">[x]</a>
								</a>
							</li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>

	
</body>
</html>