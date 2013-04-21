<?php include "templates/include/mainframe_header.php" ?>
<div id="content">
    <p align="center"><span id="error"><?php echo $error; ?></span></p>
    <p align="center"><span id="success"><?php echo $success; ?></span></p>
    <table style="width:800px" border="1" align="center">
        <tr><th align="center">Admin ID</th>
            <th width="200" align="center">Account</th>
            <th width="200" align="center">Last Update</th>
            <th width="200" align="center">Edit</th>
            <th width="200" align="center">Delete</th></tr>

        <?php foreach ($list as $admin) { ?>
            <tr>
                <td width="200" align="center">
                    <?php echo $admin->id ?>
                </td>
                <td width="200" align="center">
                    <?php echo $admin->account ?>
                </td>
                <td width="200" align="center">
                    <?php echo $admin->lastUpdate ?>
                </td>
                <td width="200" align="center">
                    <a href="editAdmin=<?php echo $admin->id ?>&null" target="sub_frame">Edit</a>
                </td>
                <td width="200" align="center">
                    <a href="deleteAdmin=<?php echo $admin->id ?>"  onclick="return confirm('Delete This Admin?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <p align="center">
        <?php echo $total ?> Administrator<?php echo ( $total != 1 ) ? 's' : '' ?> in total.
        <a href="newAdmin&null" target="sub_frame">Add a New Admin account</a>
    </p>
</div>
<?php include "templates/include/frame_footer.php" ?>