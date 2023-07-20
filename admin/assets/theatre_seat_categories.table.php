<?php
session_start();
include_once ('../db_config.php');
?>
<table id="seat_category_table" class="table" style="margin-top:10px;">
    <thead class="grey lighten-1">
        <tr>
            <th id="row_num_column">#</th>
            <th id="id_column" class="hide">ID</th>
            <th>Theatre</th>
            <th>Floor</th>
            <th>Screen</th>
            <th >No. of Seats</th>
            <th id="seat_map_column">Seat Map</th>
            <th id="action_column">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM tbl_theatre_seat_categories ";
            $result = mysqli_query($db,$sql);
            $i = 0;
            while($row= mysqli_fetch_assoc($result)){
                $theatreID = $row['theatre_id'];

                $sql_theatre = "SELECT * FROM tbl_theatres WHERE theatre_id = '$theatreID'";
                $result_theatre = $db->query($sql_theatre);
                $row_theatre = $result_theatre->fetch_assoc();
                $seats = json_decode($row['num_of_seats']);
                $sumSeats =  array_sum($seats);
                $i++;

                echo "<tr>";
                    echo "<td id='row_num_column'>{$i}</td>";
                    echo "<td id='id_column' class='hide'>{$row['seat_category_id']}</td>";
                    echo "<td>{$row_theatre['theatre_name']} - {$row_theatre['city']}</td>";
                    echo "<td>{$row['floor']}</td>";
                    echo "<td>{$row['screen']}</td>";
                    echo "<td id='seat_column'>{$sumSeats}</td>";
                    echo "<td id='seat_map_column'><button id='view_btn' class='btn btn-secondary' value='{$row['seat_category_id']}' >View</button></td>";
                    echo "<td id='action_column'><button class='delete_button btn btn-danger' seatCategoryID='{$row['seat_category_id']}'><i class='fa fa-trash'></i></button></td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#seat_category_table').DataTable({
            "ordering": false,
            "lengthMenu":[5],
            "bLengthChange":false
        });
        $('.dataTables_length').addClass('bs-select');
    });
  </script>