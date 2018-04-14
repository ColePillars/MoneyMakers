<style>
    #potgainsscroll::-webkit-scrollbar {
         width: 0px; 
         background: transparent; 
    }
</style>
<div class="w3-container" id="potentialgains" style="display: none;">
	<h3>Potential Gains</h3>
	<div id="potgainsscroll" style="overflow-y: scroll; max-height: 400px;">
        <table class="w3-table-all w3-card-4 w3-hoverable w3-centered">
        	<thead>
                <tr class="w3-light-grey">
                    <th>&nbsp;&nbsp;Date&nbsp;&nbsp;</th>
                    <th>Price</th>
                    <th>Buy/Sell</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i=0; $i < count($_SESSION['array1']); $i++)
                {
                    echo "
                <tr>
                    <td>" . $_SESSION['array1'][$i] . "</td>
                    <td>" . $_SESSION['array2'][$i] . "</td>
                    <td><b>" . $_SESSION['array3'][$i] . "</b></td>
                </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
