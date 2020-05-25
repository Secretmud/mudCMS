<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>OS</title>
		<meta name="description" content="">
		<meta name="keywords" content="Open-source,Free software,latex,programming,freedom">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../css/main.css">
	</head>
	<body>
		<div class="main">
            <div class="center-top">
                <div class="grid-content">
					<div class="content">
						<h3>Please log in</h3>
                        <a href="login.php">Log in</a>
					</div>
					<?php
						$json_string = json_encode($_SERVER, JSON_PRETTY_PRINT);
						echo $json_string;
					?>
				</div>
            </div>
        </div>
	</body>
</html>
