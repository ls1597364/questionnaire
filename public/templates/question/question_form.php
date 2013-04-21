<?php include "templates/include/frame_header.php" ?>
<div id="content">
    <p align="center"><span id="error"><?php echo $error; ?></span></p>
    <p align="center"><span id="success"><?php echo $success; ?></span></p>
    <form action="addQuestion" method="POST" target="main_frame">
        <table style="width:700px" border="1" align="center">
            <tr>
                <th align="center" width="20" >Question No.</th>
                <th width="500" align="center">Question</th>
            </tr>
            <tr>
                <td width="20" align="center"/>
            <input type="text" size="1" name="q_order" required/>
            </td>
            <td width="500">
                <input type="text" size="100" name="question" required/>
            </td>
            </tr>
        </table>

        <table style="width:700px" border="1" align="center">
            <tr>
                <th align="center" width="20" >Answer No.</th>
                <th width="500" align="center">Answer</th>
                <th width="100" align="center">Point</th>
            </tr>
            <tr>
                <td width="20" align="center" >
                    <input type="text" size="1" name="a_order" required/>
                </td>
                <td width="500">
                    <input type="text" size="100" name="ans" required/>
                </td>
                <td width="100" align ="center">
                    <input type="text" size="1" name="point" required/>
                </td>
            </tr> 
            <tr>
                <td align="center" colspan="3">
                    <input type="submit" id="submit" value="Submit"
                           onclick="parent.sub_frame.location = 'about:blank'"/>
                    <input type="submit" id="cancel" value="Cancel"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php include "templates/include/frame_footer.php" ?>