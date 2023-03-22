<table>

<?php
include_once ('../db_config.php');

function getCategory($db,$id){
    $sql = "SELECT * FROM tbl_common_seat_categories WHERE category_id='$id'";
    $result = $db->query($sql);
    while($row=mysqli_fetch_assoc($result)){
        return $row['category_name'];
    }
}

if(isset($_POST['action']) && ($_POST['action']!='')){

    $action = $_POST['action'];
    switch($action){
        case "submitForm" :
            if ( (isset($_POST['movie_id'])) && (isset($_POST['selected_date'])) && (isset($_POST['theatre_id'])) ){
                $movie_ID = mysqli_real_escape_string($db,$_POST['movie_id']);
                $selected_Date = mysqli_real_escape_string($db,date($_POST['selected_date']));
                $theatre_ID = mysqli_real_escape_string($db,$_POST['theatre_id']);
                $query_details = "SELECT * FROM tbl_shows WHERE movie_id='$movie_ID' AND starting_date<='$selected_Date' AND ending_date>='$selected_Date' AND theatre_id='$theatre_ID'";
                $result=mysqli_query($db,$query_details);
                $showID='';
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_array($result)){
                        $showID = $row["show_id"];
                    }
                }
                else{
                    echo"Not available";
                }
                $query_details_rates = "SELECT * FROM tbl_show_ticket_rates WHERE show_id='$showID'";
                $result_rates=mysqli_query($db,$query_details_rates);
                if(mysqli_num_rows($result_rates)>0){
                    echo "<tr>
                            <th>Category</th>
                            <th>Ticket Price</th> 
                        </tr>";
                    while($row=mysqli_fetch_array($result_rates)){
                        $catArray = json_decode($row['category']);
                        $rateArray = json_decode($row['ticket_rate']);
                        $i = 0;
                        foreach ($catArray as $value) {
                            echo "<tr>";
                            echo "<td>".getCategory($db,$value)."</td>";
                            echo "<td>Rs.".$rateArray[$i].".00</td>";
                            echo "</tr>";
                            $i++;
                        }
                    }
                    echo"</table>";
                }
            }
        break;
    }

}
?>

</table>


<style>
		table,th,td{
		border:1px solid black;
		}
		th,td{
			padding: 5px;
		}
        th{
            text-align:center;
        }
</style>