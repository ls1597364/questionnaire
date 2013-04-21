<?php include "templates/include/frame_header.php" ?>


<div id="content">
    <p align="center"><span id="error"><?php echo $error; ?></span></p>
    <p align="center"><span id="success"><?php echo $success; ?></span></p>
    <form action="<?php echo "../updateQuestion/id=" . $quest->id ?>" method="POST" target="main_frame">
        <table style="width:600px" border="1" align="center">
            <tr>
                <th align="center" width="20" >Question No.</th>
                <th width="400" align="center">Question</th>
                <th width="200" align="center">Action</th>
            </tr>
            <tr>
                <td width="20" align="center">
                    <?php echo $quest->seq ?>
                </td>
                <td width="400">
                    <input type="text" size="90" name="question" value="<?php echo $quest->question ?>" required/>
                </td>
                <td width="200" align="center">
                    <a href="../dropQuestion/id=<?php echo $quest->id ?>" 
                       onclick="{
                                   if (confirm('Delete This Question?')) {
                                       parent.sub_frame.location = 'about:blank';
                                       parent.main_frame.location = '../dropQuestion/id=<?php echo $quest->id ?>'
                                   }
                                   return false;
                               }">Delete</a>
                </td>
            </tr>
        </table>

        <table style="width:700px" border="1" align="center">
            <tr>
                <th align="center" width="20" >Answer No.</th>
                <th width="300" align="center">Answer</th>
                <th width="100" align="center">Point</th>
                <th width="200" align="center">Action</th>
            </tr>
            <?php foreach ($ans as $ans) { ?>
                <tr>
                    <td width="20" align="center" >
                        <input type="text" size="8" name="order_<?php echo $ans->id ?>" value="<?php echo $ans->seq ?>" required/>
                    </td>
                    <td width="300">
                        <input type="text" size="70" name="ans_<?php echo $ans->id ?>" value="<?php echo $ans->answer ?>" required/>
                    </td>
                    <td width="80" align="center">
                        <input type="text" size="12" name="point_<?php echo $ans->id ?>" value="<?php echo $ans->point ?>" required/>
                    </td>
                    <td width="200" align="center">
                        <a href="../dropAnswer/id=<?php echo $ans->id ?>&qid=<?php echo $quest->id ?>" onclick="return confirm('Delete This Answer?');">Delete</a>
                    </td>
                </tr> 
            <?php } ?>
            <tr>
                <td align="center" colspan='4'>
                    <input type="submit" id="submit" value="Submit"
                           onclick="parent.sub_frame.location = 'about:blank'"/>
                    <input type="submit" id="cancel" value="Cancel"/>
                </td>
            </tr>
        </table>
    </form>
    <p align="center" ><?php echo $total ?> Answer<?php echo ( $total != 1 ) ? 's' : '' ?> in total. 
        <a href=<?php echo "../addAnswer/qid=" . $quest->id . "&null" ?>>Add an Answer</a></p>
</div>
<?php include "templates/include/frame_footer.php" ?>