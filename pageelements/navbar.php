<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a href="../pages/index.php"><img class="nav navbar-top-links navbar-left" style="max-width:175px; margin-left:10px; margin-right:10px;" src="../resources/mm_logo.png" </img></a>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<i class="fa fa-bars fa-lg fa-fw"></i>
			</button>
		</div>
		<div class="navbar-collapse collapse" id="navbar">
			<form action="search.php" role="form" method="GET" class="nav navbar-nav navbar-left">
				<div class="form-group input-group" style="margin-top:10px; margin-left:10px; max-width:265px; min-width:200px">
					<input type="text" class="form-control"  name="SearchString" id="SearchString" placeholder="Search stocks">
					<span class="input-group-btn">
						<button class="btn btn-info btn" type="submit"><i class="fa fa-search"></i></button>
					</span>
				</div>
			</form>
			<ul class="nav navbar-nav navbar-right" style="margin-right:0px;">
				<li>
					<a href="../pages/index.php"><i class="fa fa-home fa-fw"></i>Home</a>
				</li>
				<li>
					<a href="../pages/about.php"><i class="fa fa-book fa-fw"></i>About</a>
				</li>
				<?php
				if ($_SESSION['is_logged_in']){
				echo '<li>
					<a href="../resources/logout.php"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
				</li>
';
				}
				else {
				echo '<li>
					<a href="../pages/login.php"><i class="fa fa-sign-in fa-fw"></i> Login</a>
				</li>
';
				}
				?>
			</ul>
		</div>
	</div>
</nav>
