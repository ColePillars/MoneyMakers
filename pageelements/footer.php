<footer>
	<div class="container">
		<hr>
		<div class="row">
        	<div class="col-lg-12">
              	<a href="../pages/index.php"><i class="fa fa-home"></i> Home</a>
              	<a class="footer-menu-divider" style="text-decoration: none">&sdot;</a>
               	<a href="https://github.com/ColePillars/MoneyMakers"><i class="fa fa-github"></i> GitHub</a>
            	<p id="copywrite" class="muted pull-right"> <i class="glyphicon glyphicon-copyright-mark"></i> 2018 Money Makers. All rights reserved</p>
        	</div>
      	</div>
	</div>
</footer>

<script>
$(window).on('resize', function() {
	  var win = $(this);
	  if (win.width() < 768) {
	    $('#copywrite').removeClass('pull-right');

	  } else{
		$('#copywrite').addClass('pull-right');
		  }
	});
</script>

