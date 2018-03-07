		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        	<div class="navbar-header">
          		<a href="index.php"><img class="navbar-left" style="max-width:225px;padding:6px" src="../resources/mm_logo.png" </img></a>
			</div>
            <div class="col-md-3">
            	<form action="search.php" role="form" method="POST">
               		<div class="form-group-lg input-group" style="margin-top:16px;max-width:400px">
                    	<input type="text" class="form-control"  name="SearchString" id="SearchString" placeholder="Search stocks">
                    	<span class="input-group-btn">
                        	<button class="btn btn-info btn-lg" type="submit"><i class="fa fa-search"></i></button>
                    	</span>
                	</div>
                </form>
            </div>
            <ul class="nav navbar-top-links navbar-right btn-lg">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-lg fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                        	<a href="profilepage.php"><i class="fa fa-pencil fa-fw"></i> Edit my profile</a>
                        </li>
						<li class="divider"></li>
						<li>
							<a href="../resources/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
						</li>
                    </ul>
                </li>
            </ul>
     	</nav>

