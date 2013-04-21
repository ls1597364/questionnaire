<?php include "templates/include/mainframe_header.php" ?>
<div id="content">
    <form action ="editIntro" method="POST">
        <table align="center" border="1">
            <tr width="800px">
                <td width="150px">
                    <label for="name">Question name:</label>
                </td>
                <td width="650px">
                    <input type="text" size="138" name ="intro" value="<?php echo $intro->name ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="description">Description:</label>
                </td>
                <td>
                    <textarea rows="7" cols="100" name ="description" required><?php echo $intro->description; ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" name="Submit" value="Submit"/>
                    <input type="reset" name="Reset" value="Reset" />
                    <input type="button" id="cancel" value="Cancel"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php include "templates/include/frame_footer.php" ?>