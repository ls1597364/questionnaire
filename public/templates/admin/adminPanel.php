<?php include "templates/include/header.php" ?>


<div id="content">
    <table id="table"> <!--html table-->
        <tr>
            <td valign="top" id="nav">
                <p>You are logged in as <?php echo $user ?>. <br><a href="logout">Log out</a></p>
                <br><br>
                <b>Menu</b><br><br>
                <a href= "list&null" target="main_frame" onclick="parent.sub_frame.location = 'about:blank'">Create/Delete Question</a><br><br>
                <a href= "listAdmins&null" target="main_frame" onclick="parent.sub_frame.location = 'about:blank'">Add/Delete Admin Account</a><br><br>
                <a href= "all_fbuser&null" target="main_frame" onclick="parent.sub_frame.location = 'about:blank'">View/Delete Facebook Users</a><br><br>
                <a href= "listResults&null" target="main_frame" onclick="parent.sub_frame.location = 'about:blank'">View/Delete Results</a><br><br>
                <a href= "editIntro" target="main_frame" onclick="parent.sub_frame.location = 'about:blank'">Edit Introduction</a><br><br>
                <a href= "getStat" target="main_frame" onclick="parent.sub_frame.location = 'about:blank'">Statistics</a><br><br>
            </td>
            <td id="main">
                <iframe width="1100" height="400" name="main_frame" frameborder="0"></iframe>
                <iframe width="1100" height="400" name="sub_frame" frameborder="0"></iframe>
            </td> 
        </tr>
    </table>
</div>
<?php include "templates/include/footer.php" ?>


