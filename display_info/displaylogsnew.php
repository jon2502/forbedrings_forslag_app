<?php
    function getlogs($id){
    echo '<h3 class="header_text">logs</h3>';
    $table = 'logging';
    $collums ='username, forslagID, status, timestamp';
    $values = 'forslagID = ?';
    $index = 'forslag_index';
    $bind = 's';
    $bindvalues = $id;
    $result = multipleget($table, $collums, $values, $index, $bind, $bindvalues);
    if (sizeof($result) > 0) {
        foreach ($result as $row) {
            if($row[2] == 0){
                $state = 'pending';
            }elseif($row[2] == 1){
                $state = 'reject';
            }elseif($row[2] == 2){
                $state = 'accept';
            }
        
        echo "<p class='main_text'>".$row[0]." ændrede forslags status til $state den " .$row[3]. "</p>";
        }
    }else{
        echo "<p class='main_text'>no logs found</p>";
    }
    }
?>