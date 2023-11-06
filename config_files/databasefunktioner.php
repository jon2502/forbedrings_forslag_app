<?php
function open_connect(){
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "forbedringsdb";
    $connection = mysqli_connect($host, $user, $password) or die ('unable to connect to database');
    mysqli_select_db($connection, $database) or die ('Unable to select database!');
    return $connection;
}

function close_connect($connection){
    mysqlI_close($connection);
}

function insert($table, $collums, $values, $bind, $bindvalues){
    $connection = open_connect();
    $query = mysqli_prepare($connection,"INSERT INTO $table($collums) VALUES($values)");
    $bind_params = [$query, $bind];
    foreach ($bindvalues as &$value) {
        $bind_params[] = &$value;
    }
    //var_dump($bind_params);
    // Call mysqli_stmt_bind_param with the array of parameters
    call_user_func_array("mysqli_stmt_bind_param", $bind_params);

    // Execute the query
    mysqli_stmt_execute($query);
    close_connect($connection);
}

function singleget($table, $collums, $values,$index, $bind, $bindvalues){
    $connection = open_connect();
    $query = mysqli_prepare($connection, "SELECT $collums FROM $table USE INDEX($index) WHERE $values");
    $bind_params = [$query, $bind];
    foreach ($bindvalues as &$value) {
        $bind_params[] = &$value;
    }
    //var_dump($bind_params);
    // Call mysqli_stmt_bind_param with the array of parameters
    call_user_func_array("mysqli_stmt_bind_param", $bind_params);

    mysqli_stmt_execute($query);
    $errorcheck = (mysqli_stmt_errno($query));
    if($errorcheck){
        echo "Error in query: $query. " . mysqli_stmt_error($query); 
    } else {
    $success = mysqli_stmt_get_result($query);
    $row = mysqli_fetch_assoc($success);
    }
    close_connect($connection);
    return $row;
}

function multipleget($table, $collums, $values, $index, $bind, $bindvalues){
    $connection = open_connect();
    $query = mysqli_prepare($connection, "SELECT $collums FROM $table USE INDEX($index) WHERE $values");
    mysqli_stmt_bind_param($query, $bind, $bindvalues);
    mysqli_stmt_execute($query);
    $errorcheck = (mysqli_stmt_errno($query));
    if($errorcheck){
        echo "Error in query: $query. " . mysqli_stmt_error($query); 
    } else {
    $success = mysqli_stmt_get_result($query);
    $row = mysqli_fetch_all($success);
    //var_dump($row);
    }
    close_connect($connection);
    return $row;
}

function edit($table,$collums,$values,$bind,$bindvalues){
    $connection = open_connect();
    $query = mysqli_prepare($connection,"UPDATE $table SET $collums Where $values");
    mysqli_stmt_bind_param($query, $bind, $bindvalues);
    $status = mysqli_stmt_execute($query);
    $errorcheck = (mysqli_stmt_errno($query));
    if($errorcheck){
        echo "Error in query: $query. " . mysqli_stmt_error($query); 
    }else{
        close_connect($connection);
        return $status;
    }
    
    
}

function delete($table,$values,$bind,$bindvalues){
    $connection = open_connect();
    $query = mysqli_prepare($connection, "DELETE FROM $table WHERE $values");
    mysqli_stmt_bind_param($query, $bind, $bindvalues);
    mysqli_stmt_execute($query);
    $errorcheck = (mysqli_stmt_errno($query));
    if($errorcheck){
        echo "Error in query: $query. " . mysqli_stmt_error($query); 
    }else{
        close_connect($connection);
    }
}

function get_current_ID(){
    $connection = open_connect();
    $query = "SELECT MAX(ID) FROM forslag USE INDEX(PRIMARY)";
                $result = mysqli_query($connection, $query);
            if(!$result){
                echo "Error in query: $query. " . mysqli_error($connection);
            } else{
                $row = mysqli_fetch_array($result);
                //display details
                if($row) {
                    $id = $row["MAX(ID)"];
                    return $id;
                }
            }
    close_connect($connection);
}

function deleterejects(){
    $connection = open_connect();
    $query = "DELETE FROM forslag WHERE updatedate < NOW() - INTERVAL 8 DAY AND state = 1";
    $result = mysqli_query($connection, $query);
    if(!$result){
        echo "Error in query: $query. " . mysqli_error($connection);
    } 
}

function deleteaccepts(){
    $connection = open_connect();
    $query = "DELETE FROM forslag WHERE updatedate < NOW() - INTERVAL 10 DAY AND state = 2";
    $result = mysqli_query($connection, $query);
    if(!$result){
        echo "Error in query: $query. " . mysqli_error($connection);
    } 
    close_connect($connection);
}

function deleteremaningfiles(){
    $connection = open_connect();
    $query = "DELETE from internalcomments WHERE forslagid not in (select ID FROM forslag)";
    $result = mysqli_query($connection, $query);
    if(!$result){
        echo "Error in query: $query. " . mysqli_error($connection);
    } 

    $query1 = "DELETE from logging WHERE forslagid not in (select ID FROM forslag)";
    $result1 = mysqli_query($connection, $query1);
    if(!$result1){
        echo "Error in query: $query. " . mysqli_error($connection);
    }
    
    $query2 = "SELECT parthname FROM files USE INDEX(forslag_index) WHERE forslagid not in (select ID FROM forslag USE INDEX(PRIMARY))";
    $result2 = mysqli_query($connection, $query2);
    if(!$result2){
        echo "Error in query: $query2. " . mysqli_error($connection);
    } else {
        if (mysqli_num_rows($result2) > 0) {
            while ($row = mysqli_fetch_array($result2)) {
                unlink($row['parthname']);
            }
        }
        $query3 = "DELETE from files WHERE forslagid not in (select ID FROM forslag)";
        $result3 = mysqli_query($connection, $query3);
        if(!$result3){
            echo "Error in query: $query2. " . mysqli_error($connection);
        }
    }
    close_connect($connection);
}