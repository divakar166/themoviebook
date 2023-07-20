<?php
    include_once ('../db_config.php');
?>
<table id="carousel_table" class="table">
    <thead>
        <th>#</th>
        <th>Movie</th>
        <th>Casts</th>
        <th class="hide">Banner</th>
        <th>ACTION</th>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT A.id, A.carousel_image,B.casts,B.banner , B.movie_name FROM tbl_carousel A, tbl_movies B WHERE A.movie_id = B.movie_id ORDER BY A.id DESC";
            $result = $db->query($sql);
            if($result->num_rows>0){
                $i=0;
                while($row=$result->fetch_assoc()){
                    $i++;
                    echo "<tr>";
                        echo "<td>{$i}</td>";
                        echo "<td>{$row['movie_name']}</td>";
                        echo "<td>{$row['casts']}</td>";
                        echo "<td class='hide'>{$row['banner']}</td>";
                        echo "<td>
                            <button class='view_button btn btn-secondary'><i class='fas fa-eye'></i></button>
                            <button type='button' class='delete_button btn btn-danger' ID='{$row['id']}'><i class='fa fa-trash'></i></button>
                        </td>";
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#carousel_table').DataTable({
            "ordering": false,
            "lengthMenu":[5],
            "bLengthChange":false
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>