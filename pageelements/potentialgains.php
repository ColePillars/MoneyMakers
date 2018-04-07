<div class="w3-container" id="potentialgains" style="display: none;">
    <table class="w3-table-all w3-card-4 w3-hoverable w3-centered">
    	<h3></h3>
    	<thead>
            <tr class="w3-light-grey">
                <th>&nbsp;&nbsp;Date&nbsp;&nbsp;</th>
                <th>Price</th>
                <th>Buy/Sell</th>
            </tr>
        </thead>
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
    </table>
</div>