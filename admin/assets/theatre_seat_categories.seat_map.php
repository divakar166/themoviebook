<?php

include_once ('../db_config.php');
include_once('../functions.php');
$theatre_id = $_POST['theatre_name'];
$screen = $_POST['theatre_screen'];
$categories = $_POST['category'];
$num_of_rows = $_POST['row'];
$num_of_cols = $_POST['col'];

$sql_check = "SELECT * FROM tbl_theatre_seat_categories WHERE theatre_id = '$theatre_id' AND screen = '$screen'";
$sql_result = $db->query($sql_check);
if(mysqli_num_rows($sql_result) > 0){
    $seatsArray = [];
    while ($data = mysqli_fetch_assoc($sql_result)) {
        $new_category = array_merge(json_decode($data['category_name']),$categories);
        $new_row = array_merge(json_decode($data['num_of_rows']),$num_of_rows);
        $new_col = array_merge(json_decode($data['num_of_columns']),$num_of_cols);
        $max_col = max($new_col);
        echo '<table class="table seat_map_wrap">';
            echo '<tbody>';
                echo '<tr class="row_seat_column_index">';
                    echo '<td></td>';
                    echo '<td class="row_seat_column_numbers">';
                        for ($col = 1; $col <= $max_col; $col++){
                            echo '<span class="seat_column_number">';
                                echo '<div>'.$col.'</div>';
                            echo '</span>';
                        }
                    echo '</td>';
                echo '</tr>';

            $alpha = range('A', 'Z');
            $totalSeats = [];
            for ($t_s=0; $t_s <= count($new_row) - 1 ; $t_s++) { 
                array_push($totalSeats, $new_row[$t_s] * $new_col[$t_s]);
            }
            for ($cat=0; $cat <= count($new_category) - 1; $cat++) {
                $rowArray = [];
                echo '<tr class="category_head"><td colspan="2">' . $new_category[$cat] . '</td></tr>';
                if($new_col[$cat] < $max_col){
                    $tdCheck = true;
                    $diff = ($max_col - $new_col[$cat]) / 2;
                    $addup = '';
                    for ($i=1; $i <= $diff ; $i++) { 
                        $addup .= '<span class="seat"></span>';
                    }
                }else{
                    $tdCheck = false;
                }
                for ($row = $new_row[$cat]; $row >= 1 ; $row--){
                        $colArray = [];
                        echo '<tr class="seat_row">';
                            echo '<td>';
                                echo '<div class="seat_row_label">'.$alpha[$new_row[$cat] - $row].'</div>';
                            echo '</td>';
                            echo '<td class="seat_row_seats">';
                                if($tdCheck){
                                    echo $addup;
                                }
                                for ($col = 1; $col <= $new_col[$cat]; $col++){
                                    $code = $alpha[$new_row[$cat] - $row] . $col;
                                    array_push($colArray, $code);
                                    echo '<span class="seat">';
                                        echo '<div>';
                                            echo '<a i="seat_label" row_index="'.$row.'" col_index="'.$col.'">1</a>';
                                        echo '</div>';
                                    echo '</span>';
                                }
                                $strColArray = implode(',', $colArray);
                                array_push($rowArray, $strColArray);
                            echo '</td>';
                        echo '</tr>';
                        $last = $alpha[($new_row[$cat] - $row) + 1];
                }
                array_push($seatsArray, $rowArray);
                $alpha = range($last,'Z');
            }
                echo '<tr>
                    <td colspan="2">
                        <div class="screen_area">
                            <span>THEATRE SCREEN</span>
                        </div>
                    </td>
                </tr>';
            echo '</tbody>';
        echo '</table>';
    }
}else{
    $max_col = max($num_of_cols);
    $max_rows = array_sum($num_of_rows);
    $seatsArray = [];
    echo '<table class="table seat_map_wrap">';
        echo '<tbody>';
            echo '<tr class="row_seat_column_index">';
                echo '<td></td>';
                echo '<td class="row_seat_column_numbers">';
                    for ($col = 1; $col <= $max_col; $col++)
                    {
                        echo '<span class="seat_column_number">';
                            echo '<div>'.$col.'</div>';
                        echo '</span>';
                    }
                echo '</td>';
            echo '</tr>';

        $alpha = range('A', 'Z');
        $totalSeats = [];
        for ($t_s=0; $t_s <= count($num_of_rows) - 1 ; $t_s++) { 
            array_push($totalSeats, $num_of_rows[$t_s] * $num_of_cols[$t_s]);
        }
        for ($cat=0; $cat <= count($categories) - 1; $cat++) {
            $rowArray = [];
            echo '<tr class="category_head"><td colspan="2">' . get_category_name($db,$categories[$cat]) . '</td></tr>';
            if($num_of_cols[$cat] < $max_col){
                $tdCheck = true;
                $diff = ($max_col - $num_of_cols[$cat]) / 2;
                $addup = '';
                for ($i=1; $i <= $diff ; $i++) { 
                    $addup .= '<span class="seat"></span>';
                }
            }else{
                $tdCheck = false;
            }
            for ($row = $num_of_rows[$cat]; $row >= 1 ; $row--){
                    $colArray = [];
                    echo '<tr class="seat_row">';
                        echo '<td>';
                            echo '<div class="seat_row_label">'.$alpha[$num_of_rows[$cat] - $row].'</div>';
                        echo '</td>';
                        echo '<td class="seat_row_seats">';
                            if($tdCheck){
                                echo $addup;
                            }
                            for ($col = 1; $col <= $num_of_cols[$cat]; $col++){
                                $code = $alpha[$num_of_rows[$cat] - $row] . $col;
                                array_push($colArray, $code);
                                echo '<span class="seat">';
                                    echo '<div>';
                                        echo '<a i="seat_label" row_index="'.$row.'" col_index="'.$col.'">1</a>';
                                    echo '</div>';
                                echo '</span>';
                            }
                            $strColArray = implode(',', $colArray);
                            array_push($rowArray, $strColArray);
                        echo '</td>';
                    echo '</tr>';
                    $last = $alpha[($num_of_rows[$cat] - $row) + 1];
            }
            array_push($seatsArray, $rowArray);
            $alpha = range($last,'Z');
        }
        echo '<tr>
            <td colspan="2">
                <div class="screen_area">
                    <span>THEATRE SCREEN</span>
                </div>
            </td>
        </tr>';
        echo '</tbody>';
    echo '</table>';
}


?>

<style>
    .seat_map_wrap {
        margin-top: 10px;
        margin-bottom: 0;
        border-spacing: 0;
        border-collapse: collapse;
        background-color: transparent;
        display: inline-block;
        text-align: center;
        padding: 2%;
        width: auto;
        max-width: 100%;
    }
    @media only screen and (max-width: 570px) {
    .seat_map_wrap {
        width: 1040px !important;
        max-width: 1040px !important;
    }}
    tbody{
        width: 100%;
        height: 100%;
    }
    .seat_map_wrap .screen_area span {
        background-color: #6b6b6b;
        display: block;
        border-radius: 5px;
        color: #fff;
        position: relative;
        width: 100%;
        padding: 2px 6px;
        margin-top: 10px;
        user-select: none;
    }
    .seat_map_wrap td {
        border-top: none !important;
        padding: 0 !important;
        line-height: 1.42857143;
    }
    .seat_map_wrap td {
        padding: 0;
        vertical-align: middle;
        border-top: none;
    }
    .category_head{
        width: 100%;
        height: 100%;
        font-weight: bold;
    }
    .seat_map_wrap .seat_row_label {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #4c4d4f;
        font-size: 12px;
        margin-right: 6px;
        margin-top: 4px;
        user-select: none;
    }
    .seat_map_wrap .seat {
        float: left;
        margin: 4px 3px;
        width: 24px;
    }
    .seat_map_wrap .seat a {
        display: inline-block;
        font-family: inherit;
        font-size: 10px;
        line-height: 26px;
        box-shadow: 0 0 0 1px #f09c0b inset;
        height: 26px;
        text-align: center;
        width: 26px;
        border-radius: 26%;
        color: transparent;
        cursor: pointer;
        font-weight: bolder;
        text-decoration: none;
        background: #fff9d8;
        user-select: none;
    }
    .seat_map_wrap .seat a:hover {
        color: transparent;
        background: #f5a825;
        text-decoration: none;
        transition: .5s;
    }
    .seat_map_wrap .seat .selected a{
        background: #f5a825;
        text-decoration: none;
        box-shadow: 0 0 0 1px #f5a825 inset;
    }
    .seat_map_wrap .seat_column_number {
        float: left;
        margin: 4px 3px;
        width: 24px;
        user-select: none;
    }
</style>

<script>
$(document).ready(function () {

    $("a").click(function() {
        var row_index = $(this).attr("row_index");
        var col_index = $(this).attr("col_index");
        $(this).parent().toggleClass("selected");
        
        if($(this).parent().hasClass("selected")) {
            seats_array[row_index-1][col_index-1] = 0;
        }else{
            seats_array[row_index-1][col_index-1] = 1;
        }

        seatsCount = 0;
        seats_label_array = new Array(num_of_rows);
        for (var i = 0; i < num_of_rows; i++) {
            seats_label_array[i] = new Array(num_of_cols);
            var row_label = String.fromCharCode(65 + (num_of_rows - i - 1));
            var seat_num = 1;
            for (var j = 0; j < num_of_cols; j++) {
                if(seats_array[i][j] == 1) {
                    seats_label_array[i][j] = row_label + seat_num;
                    seat_num++;
                    seatsCount++;
                }else{
                    seats_label_array[i][j] = 0;
                }
            }
        }

        $("#seatsArray").val(seats_label_array);
        $("#num_of_seats").val(seatsCount);
    });
    var array = <?php echo json_encode($seatsArray); ?>;
    $('#seatsArray').val(JSON.stringify(array));
    var seats = <?php echo json_encode($totalSeats); ?>;
    $('#seats').val(JSON.stringify(seats));
});
</script>

<?php
echo '<div id="seatsArray"></div>';
?>