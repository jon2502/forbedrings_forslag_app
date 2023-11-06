<?php
    function form($self){
        $form ="
            <form action=".$self." method=\"post\" id=\"sendForm\" enctype='multipart/form-data'>
                <label for=\"title\">title:</label><br>
                <input type=\"text\" name=title value=\"\" class=\"formfield\"><br>
                <label for=\"name\">name:</label><br>
                <input type=\"text\" name=\"name\" value=\"\" class=\"formfield\"><br>
                <label for=\"email\">email:</label><br>
                <input type=\"text\" name=\"email\" value=\"\" class=\"formfield\"><br>
                <label for=\"files[]\">files:</label><br>
                <input type=\"file\" name=\"files[]\" value=\"files\" multiple=\"multiple\" class=\"formfield\"><br>
                <label for=\"kategori\">kategori:</label><br>
                <select name=\"kategori\" id=\"kategori\" class=\"formfield\">
                    <option value=\"test1\">test1</option>
                    <option value=\"test2\">test2</option>
                    <option value=\"test3\">test3</option>
                </select><br>
                <label for=\"comments\">comments:</label><br>
                <textarea name=\"comments\" id=\"comments\" cols=\"30\" rows=\"7\" class=\"formfield\">add comment</textarea><br><br>
                <input type=\"submit\" value='submit' name='submit' class='main_text'>
            </form>
            ";
        return $form;
    }
    function listheader(){
        $result = "
        <div id=\"list_header\">
                    <h3>title</h3>
                    <h3>user</h3>
                    <h3>email</h3>
                    <h3>kategori</h3>
                    <h3>date added</h3>
                    <h3>more info</h3>
                </div>
        ";
        echo $result;
    }
    function listinfo($row) {
        $result = "
        <div class=\"listinfo\">
                            <tr>
                                <p>".htmlentities($row[1])."</p>
                                <p>".htmlentities($row[2])."</p>
                                <p>".htmlentities($row[3])."</p>
                                <p>".htmlentities($row[4])."</p>
                                <p>".htmlentities($row[5])."</p>
                                <a href=\"info.php?id=".htmlentities($row[0])."\" class=\"button_link main_text\">more info</a>
                            </tr>
                    </div>
        ";
        echo $result;
    }
    function infomain($row){
        $result = "
        <h2 class=\"header_text\">".htmlentities($row[1])."</h2>
        <h4 class=\"main_text\"> af ".htmlentities($row[2])."</h4>
        <p class=\"main_text\">".htmlentities($row[4])."</p>
        <p class=\"main_text\">This release was published on ".htmlentities($row[7])." For more information, please contact ".$row[3]."</p>
        <p class=\"main_text\">last updated the ".htmlentities($row[8])."</p>
        ";
        echo $result;
    }
    function jirainfo($username,$text){
        $result ="
        <div class =\"jira_row\">
        <p class=\"main_text\">$username</p>
        <p class=\"main_text\">$text</p>
        </div>
        ";
        echo $result;
    }
    function editcomment($row, $id, $forslag ){
        $result ="
        <section class=\"form_setup\">
                <form method=\"post\">
                    <label for=\"comments\">comments:</label><br>
                    <textarea name=\"comments\" id=\"comments\" cols=\"30\" rows=\"7\" >".htmlentities($row['content'])."</textarea><br><br>
                    <input type=\"hidden\" name=\"id\" value=".$id.">
                    <input type=\"hidden\" name=\"forslagid\" value=".$forslag.">
                    <input type='submit' value='save' name='save'>
                </form>
            </section>
        ";
        echo $result;
    }

    function comment_header(){
        $result = "
        <div id=\"listinfo_header\">
        <h3>user</h3>
        <h3>content</h3>
        <h3>date added</h3>
        <h3>option(s)</h3>
        </div>
        <section class=\"listgrid\">
        ";
        echo $result;
    }
    function comments($row){
        $result = "
        <div class=\"infolist\">
        <h5>".$row[1]."</h5>
        <p>".$row[2]."</p>
        <p>".$row[4]."</p>
        ";
        echo $result;
    }

    function commentsoptions($row, $id){
        $result = "
        <a href=\"./editcomment.php?id=".$row[0]."&forslagid=".$id."\" class=\"button_link main_text\">edit</a>
        <form method=\"post\">
            <input type=\"hidden\" value=".$row[0]." name=\"commentid\">
            <input type=\"submit\" value='delete-comment' name='delete-comment' class=\"main_text\">
        </form>
        ";
        echo $result;
    }

    function commentuploader(){
        $result = "
        <h3 class='header_text'>add comments</h3>
        <form method='post'>
            <label for='comments'>comments:</label><br>
            <textarea name='comments' id='comments' cols='30' rows='7'></textarea><br><br>
            <input type='submit' value='add-comment' name='add-comment'>
        </form><br>
        <h2 class='header_text'>comments</h2>
        ";
        echo $result;
    }
?>