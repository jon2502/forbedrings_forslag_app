<?php
function uploadfiles($filename,$filetype,$fileextension,$filedata,$title,$name,$email,$kategori,$comments){
$table = "forslag";
$collums = 'ID';
$values = "title=? AND name = ? AND email= ? AND kategori=? AND comments=?";
$index ="findID";
$bind ='sssss';
$bindvalues = array($title,$name,$email,$kategori,$comments);
$result = singleget($table, $collums, $values,$index, $bind, $bindvalues);

if($result){
    $objid = $result['ID'];
    $table2 = "files";
    $collums2 = 'filename, filetype, extension, forslagid';
    $values2 = "?, ?, ?, ?";
    $bind2 ='ssss';
    $bindvalues2 = array($filename, $filetype, $fileextension, $objid);
    insert($table2,$collums2,$values2,$bind2,$bindvalues2);

    $table3 = "files";
    $collums3 = 'ID';
    $values3 = "filename=? AND filetype=? AND extension=? AND forslagid=?";
    $index3 ='PRIMARY';
    $bind3 ='ssss';
    $bindvalues3 = array($filename, $filetype, $fileextension, $objid);
    $result2 = singleget($table3, $collums3, $values3, $index3, $bind3, $bindvalues3);
    
        if($result2){
            $fileid = $result2['ID'];
            $target_dir = "files/";
            $target_file = $target_dir . $fileid;
            $uploadOk = 1;
            $table4 = "files";
            $collums4 = 'parthname=?';
            $values4 = "ID=$fileid";
            $bind4 ='s';
            $bindvalues4 = $target_file;
            $result3 = edit($table4,$collums4,$values4,$bind4,$bindvalues4);
            if(!$result3){
                echo "Error in query: $result3. ";
            } else{
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                  // if everything is ok, try to upload file
                  } else {
                        //save file in files 
                    if (move_uploaded_file($filedata, $target_file)) {
                      echo "The file ". htmlspecialchars( basename( $filename )). " has been uploaded.";
                    } else {
                      echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }
    }
}