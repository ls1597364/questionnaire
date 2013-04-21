<?php include "templates/include/frame_header.php" ?>
<div id="NewResultForm">
    <p align="center"><span id="error"><?php echo $error; ?></span></p>
    <form action="./addResult" method="POST" target="main_frame">
        <table style="width:800px" border="1" align="center">
            <tr><th width='200' align='center'>Type</th>
                <td width='600'><input type="text" size="100%" name="type" required/></td>
            </tr>
            <tr><th width='200' align='center'>Mark(lower)</th>
                <td width='600'><input type="text" size="100%" name="lower" required/></td>
            </tr>
            <tr><th width='200' align='center'>Mark(upper)</th>
                <td width='600' align='center'><input type="text" size="100%" name="upper" required/></td>
            </tr>
            <tr><th width='200' align='center'>Description</th>
                <td width='600' align='center'><textarea rows="10" cols="72%" name ="content" required></textarea></td>
            </tr>
            <tr>
                <td align="center" colspan="2">
                    <input type="submit" id="submit" value="Submit"
                           onclick="parent.sub_frame.location = 'about:blank'"/>
                    <input type="submit" id="cancel" value="Cancel"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php include "templates/include/frame_footer.php" ?>
