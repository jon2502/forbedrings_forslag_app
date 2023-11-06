<?php
    function getfiles($id){
    $table = 'files';
    $collums ='ID, parthname, filename, filetype,	extension, forslagID';
    $values = 'forslagID = ?';
    $index = 'forslag_index';
    $bind = 's';
    $bindvalues = $id;
    $result = multipleget($table, $collums, $values, $index, $bind, $bindvalues);
    if (sizeof($result) > 0) {
        $img="";
        $video="";
        $audio="";
        foreach ($result as $row) {
            if($row[3] == 'image/png' || $row[3] == 'image/jpg' || $row[3] == 'image/gif'){
                $filecontent = file_get_contents($row[1]);
                $img .= '<img src="data:'.$row[3].';base64,'.base64_encode($filecontent).'"class ="fileimg"/>';
            }
            if($row[3] == 'video/mp4'){
                $filecontent = file_get_contents($row[1]);
                $video .= "
                <video class =\"filevideo\" controls disablePictureInPicture>
                    <source src='data:".$row[3].";base64,".base64_encode($filecontent)."'>
                Your browser does not support the video element.
                </video>
                ";
            }
            if($row[3] == 'audio/mpeg'){
                $filecontent = file_get_contents($row[1]);
                $audio .= "
                <audio class =\"fileaudio\" controls>
                    <source src='data:".$row[3].";base64,".base64_encode($filecontent)."'>
                Your browser does not support the audio element.
                </audio>
                ";
            }
            }
            echo $img;
            echo $video;
            echo $audio;
        } else {
            echo '<p class="main_text">no files could be found</p>';
    }
    
}
