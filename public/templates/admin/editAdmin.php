<?php include "templates/include/frame_header.php" ?>
<div id="content">
    <p align="center"><span id="error"><?php echo $error; ?></span></p>
    <p align="center"><span id="success"><?php echo $success; ?></span></p>
    <?php foreach ($admin as $admin) { ?>
        <form action="<?php echo "editAdmin=" . $admin->id ?>" target="main_frame" method="POST" id="editAdminForm">
            <table style="width:800px" align="center" border='1'>
                <tr><th align="center" width="200px">Admin ID</th>
                    <th align="center" width="200px">Username</th>
                    <th align="center" width="200px">Password</th>
                    <th align="center" width="200px">Confirm Password</th>
                </tr>
                <tr><td width='200' align='center'>
                        <?php echo $admin->id ?>
                    </td>
                    <td width='200'>
                        <input type="text" name="account" id="account" size="31" required value="<?php echo htmlspecialchars($admin->account) ?>"/>
                    </td>
                    <td width='200'>
                        <input type="password" name="password" id="password" size="31" required >
                    </td>	
                    <td width='200'>
                        <input type="password" name="confirm_pw" id="confirm_pw" placeholder="Enter password again" required size="31">
                    </td>
                </tr>
                <tr>
                    <td colspan='4' align='center'>
                        <input type="submit" name="saveChanges" value="Save Changes" onclick="parent.sub_frame.location = 'about:blank'"/>
                        <input type="submit" id="cancel" value="Cancel" />
                    </td>
                </tr>
            </table>
        </form>
        <p align="center">
            <a href="deleteAdmin=<?php echo $admin->id ?>" onclick="{
                                    if (confirm('Delete This Question?')) {
                                        parent.sub_frame.location = 'about:blank';
                                        parent.main_frame.location = 'deleteAdmin=<?php echo $admin->id ?>'
                                    }
                                    return false;
                                }"> Delete This Account </a>
        </p>
    <?php } ?>
</div>
<?php include "templates/include/frame_footer.php" ?>