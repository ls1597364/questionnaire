<?php include "templates/include/frame_header.php" ?>
<div id="content">
    <p align="center"><span id="error"><?php echo $error; ?></span></p>
    <p align="center"><span id="success"><?php echo $success; ?></span></p>
    <form action="newAdmin" method="POST" target="main_frame">
        <table style="width:600px" border='1' align="center">
            <tr><th align="center" width='200'>Username</th>
                <th align="center" width='200'>Password</th>
                <th align="center" width='200'>Confirm Password</th>
            </tr>
            <tr><td width='200'><input type="text" name="account" id="account" size="31" required placeholder="Username"/></td>
                <td width='200'><input type="password" name="password" id="password" size="31" required placeholder="Password"></td>	
                <td width='200'><input type="password" name="confirm_pw" id="confirm_pw" placeholder="Enter password again" required size="31"></td>
            </tr>
            <tr>
                <td colspan='3' align='center'>
                    <input type="submit" name="saveChanges" value="Save Changes" 
                           onclick="parent.sub_frame.location = 'about:blank'"/>    
                    <input type="submit" id="cancel" name="cancel" value="Cancel" />
                </td>
            </tr>
        </table> 
    </form>
</div>			
<?php include "templates/include/frame_footer.php" ?>