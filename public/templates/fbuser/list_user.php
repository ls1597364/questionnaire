<?php include "templates/include/mainframe_header.php" ?>
<div id="content">
    <p align="center"><span id="success"><?php echo $success; ?></span></p>
    <table  border="1" align="center" style="width:1100px">
        <tr><th align="center" width='100'>Facebook ID</th>
            <th align="center" width='200'>Username</th>
            <th align="center" width='200'>First Name</th>
            <th align="center" width='50'>Gender</th>
            <th align="center" width='100'>Birthday</th>
            <th align="center" width='200'>Email</th>
            <th align="center" width='100'>Last Update</th>
            <th colspan =2 align="center" width='100'>Action</th>
            <?php foreach ($list as $user) { ?>
            <tr>
                <td width='100' align="center">
                    <?php echo $user->id ?>
                </td>
                <td width='200' align="center">
                    <?php echo $user->username ?>
                </td>
                <td width='200' align="center">
                    <?php echo $user->firstName ?>
                </td>
                <td width='50' align="center">
                    <?php echo $user->gender ?>
                </td>
                <td width='100' align="center">
                    <?php echo $user->birthday ?>
                </td>
                <td width='200' align="center">
                    <?php echo $user->email ?>
                </td>
                <td width='100' align="center">
                    <?php echo $user->lastUpdate ?>
                </td>
                <td width='50' align="center">
                    <a href="details=<?php echo $user->id ?>" target="sub_frame">Details</a>
                </td>
                <td width='50' align="center">
                    <a href="delete=<?php echo $user->id ?>" onclick="return confirm('Delete This Record?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <p>
        <?php echo $total ?> Facebook user record<?php echo ( $total != 1 ) ? 's' : '' ?> in total.
    </p>
</div>
<?php include "templates/include/frame_footer.php" ?>