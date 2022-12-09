<?php
session_start();
ob_start();
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>CBCYBER - SQLi Demo</title>
		<link href="img/icon.png" rel="icon">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<link href="css/styles.css" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar navbar-expand-md navbar-dark bg-primary">
			<div class="container-fluid">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="">Blog</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="">About</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="">Portal</a>
						</li>
					</ul>
					<ul class="navbar-nav ms-auto">
						<li class="nav-item">
							<a class="nav-link" href="">Sign Up</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" href="">Sign In</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container-fluid">
			<div id="queryBox" class="alert alert-info alert-dismissible show fade mt-2" role="alert" hidden>
				<span id="queryText"></span>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<div id="successBox" class="alert alert-success alert-dismissible show fade mt-2" role="alert" hidden>
				<span id="successText"></span>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<div id="errorBox" class="alert alert-danger alert-dismissible show fade mt-2" role="alert" hidden>
				<span id="errorText"></span>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<!--
				Definitley do NOT try any SQLi on this form.
				We are still figuring out how to santize input...
				- Developer
			-->
			<div class="card p-5 mx-auto shadow mt-5" style="max-width: 400px;">
				<img class="rounded-circle border mx-auto" src="img/icon.png" width="100px">
				<h3 class="my-3 text-center">CyberCoin Login</h3>
				<form action="" method="POST">
					<input type="text" class="form-control my-3" placeholder="Username" name="username" required>
					<input type="password" class="form-control my-3" placeholder="Password" name="password" required>
					<button type="submit" class="btn btn-primary w-100">Sign In</button>
				</form>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	$mysqli = new mysqli("sqli_lab_mysql", "root", "", "sqli_demo");
	if ($mysqli -> connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
		exit();
	}

	$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
	
	$query = htmlentities($sql);
	echo "<script>document.getElementById('queryBox').removeAttribute('hidden'); document.getElementById('queryText').innerHTML = '$query';</script>";
	
	try{
		$result = $mysqli->query($sql);
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$id = htmlentities($row["id"]);
			$user = htmlentities($row["username"]);
			$pass = htmlentities($row["password"]);
			$email = htmlentities($row["email"]);
			echo "<script>document.getElementById('successBox').removeAttribute('hidden'); document.getElementById('successText').innerHTML = 'Successfuly logged in!<br>ID: $id<br>Username: $user<br>Password: $pass<br>Email: $email';</script>";
			
		}
		else{
			echo "<script>document.getElementById('errorBox').removeAttribute('hidden'); document.getElementById('errorText').innerHTML = 'Invalid username or password!';</script>";
		}
	}
	catch (Exception) {
		$err = htmlentities($mysqli->error);
		echo "<script>document.getElementById('errorBox').removeAttribute('hidden'); document.getElementById('errorText').innerHTML = '$err';</script>";
 	}	
}
?>
