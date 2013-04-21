<?php include "templates/include/mainframe_header.php" ?>
<div id="QuestionTable">

    <form action="changeOrder" method="POST">
        <p align="center"><span id="error"><?php echo $error; ?></span></p>
        <p align="center"><span id="success"><?php echo $success; ?></span></p>
        <table style="width:800px" border="1" align="center">
            <tr><th align="center" width="50" >Question No.</th>
                <th width="600" align="center">Question</th>
                <th width="100" align="center">Last Update</th>
            </tr>
            <?php foreach ($list as $list) { ?>
                <tr id="<?php echo $list->id ?>" onclick="parent.sub_frame.location = 'getQuestion/id=<?php echo $list->id ?>&null'">
                    <td width="50"><input type="text" size="10" name="qid_<?php echo $list->id ?>" value="<?php echo $list->seq ?>" required/></td>
                    <td width="600"><?php echo $list->question ?></td>
                    <td width="100"><?php echo $list->lastUpdate ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td align="center" colspan='3'>
                    <input type="submit" name="submit" value="Submit" />
                    <input type="reset" name="Reset" value="Reset" />
                </td>
            </tr>
        </table>
</div>
<div id="txtHint"></div>
<p align="center">
    <?php echo $total ?> Question<?php echo ( $total != 1 ) ? 's' : '' ?> in total.
    <a href="addQuestion&null" target="sub_frame">Add Question</a>
</p>
<?php include "templates/include/frame_footer.php" ?>