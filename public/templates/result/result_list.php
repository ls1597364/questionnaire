<?php include "templates/include/mainframe_header.php" ?>
<div id="content">
    <p align="center"><span id="error"><?php echo $error; ?></span></p>
    <p align="center"><span id="success"><?php echo $success; ?></span></p>
    <?php foreach ($list as $list) { ?>

        <table style="width:800px" border="1" align="center" onclick="parent.sub_frame.location = 'editResult/id=<?php echo $list->id ?>&null'">
            <tr>
                <th width='200' align='center'>Type</th>
                <td width='600' align='center'><?php echo $list->type ?></td>
            </tr>
            <tr>
                <th width='200' align='center'>Mark(lower)</th>
                <td width='600' align='center'><?php echo $list->lower ?></td>
            </tr>
            <tr>
                <th width='200' align='center'>Mark(upper)</th>
                <td width='600' align='center'><?php echo $list->upper ?></td>
            </tr>
            <tr>
                <th width='200' align='center'>Description</th>
                <td width='600' align='center'><?php echo $list->content ?></td>
            </tr>
            <tr>
                <th width='200' align='center'>Last Update</th>
                <td width='600' align='center'><?php echo $list->lastUpdate ?></td>
            </tr>
        </table><br>
    <?php } ?>
    <p align="center"><?php echo $total ?> Result type<?php echo ( $total != 1 ) ? 's' : '' ?> in total.
        <a href="addResult&null">Add a type</a>
    </p>
</div>
<?php include "templates/include/frame_footer.php" ?>