<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
	//ajax search bar that searches names of stocks
    $(document).ready(function(e) {
    	$("#SearchString").keyup(function(){
    		
    		$("#searchResult").show();
    		var x = $(this).val();
    		$.ajax(
    				{
    					type: 'GET',
    					url: '../resources/indexsearch.php',
    					data: 'search=' +x,
    					success: function(data){
    						$("#searchResult").html(data);
    					}
    				,
    				});
    		var urlResult = 'search.php?search='+x;
    	});
    });
</script>

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a href="index.php"><img class="navbar-brand" src="../resources/mm_logo.png" style="width:100%;height:100%"</img>
        </a>
    </div>
    <div class="col-lg-3">
       <form action= "search.php" role="form" method="POST">
        <div class="form-group-lg input-group" style="margin-top:12px">
            <input type="text" class="form-control" name="SearchString" id="SearchString" placeholder="Search stocks">
            <span class="input-group-btn">
                <button class="btn btn-info btn-lg" type="buttosubmitn"><i class="fa fa-search"></i>
                </button>
            </span>
            <div type="text" id="searchResult"></div>
        </div>
        </form>
    </div>
    <div class="col-lg-6">
    </div>
    <ul class="nav navbar-top-links navbar-right btn-lg">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-lg fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
				<li class="divider"></li>
				<li><a href="../resources/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
				</li>
            </ul>
        </li>
    </ul>
</nav>
