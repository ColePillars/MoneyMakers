<div class="w3-container">
    <div class="w3-card-4" style="background-color: #337ab7">
        <header class="w3-container w3-center">
    		<div class="row" style="color: white">
            	<div class="h4">
                    <?php 
                    echo $GLOBALS['StockFullName'];
                    ?>
                </div>
            </div>
            <div class="row" style="color: white">
                <div class="col-xs-6">
                    <i class="fa fa-bar-chart fa-5x"></i>
                </div>
                <div class="col-xs-6" style="margin-bottom:6px">
                	Stock Symbol:
                    <?php 
                    echo $_GET['Symbol'];
                    ?>
                </div>
            </div>
        </header>
        <div class="w3-container" style="background-color: #f5f5f5; padding-top: 5px;">
        	<ul class="nav nav-pills">
                <li class="active"><a href="#status-pills" data-toggle="tab">Status</a>
                </li>
                <li><a href="#details-pills" data-toggle="tab">Details</a>
                </li>
                <li><a href="#simulation-pills" data-toggle="tab">Sim</a>
                </li>
                <?php
                ShowSubUnsubIcon();
                ?>
        	</ul>
		</div>
		<footer class="w3-container" style="background-color: #f5f5f5; padding-bottom: 5px;">
			<div class="tab-content">
                <div class="tab-pane fade in active" id="status-pills">
                    <h3 class='alert alert-success' style='margin-top:3px;margin-bottom:3px;font-size:28px;text-align:center'>
                    	<?php
                        include ('../resources/connection.php');
                        $status = "SELECT Final_Decision FROM StockInfo.Buy_Sell_Hold WHERE Symbol = '" .  $_GET['Symbol'] . "';";
                        $statusResult = mysqli_query($conn, $status);
                        if ($statusResult->num_rows > 0){
                            while($row = $statusResult->fetch_assoc()) {
                                echo $row['Final_Decision'];
                            }
                        }
                        ?>
                  	</h3>
                </div>
                <div class="tab-pane fade" id="details-pills">
                	<h5 class='alert alert-info' style='margin-top:3px;margin-bottom:3px;font-size:28px;text-align:center'>
                    <?php 
                    ShowCompanyInformation($_GET['Symbol']);
                    ?>
                    </h5>
                </div>
                <div class="tab-pane fade" id="simulation-pills">
                	<h5 class='alert alert-warning' style='margin-top:3px;margin-bottom:3px;font-size:28px;text-align:center;font-size:16px;'>
                    	<?php 
                        echo "<b>Potential Gains:</b> " . round(PotentialGains(1000, 100, 0, $_GET['Symbol']), 3) . "&nbsp;%</br>";
                        echo "<b>Market Gains:</b> " . round(MarketGains(1000, 100, 0, $_GET['Symbol']), 3) . "&nbsp;%";
                        ?>
                    </h5>
                </div>
        	</div>
		</footer>
    </div>
</div>