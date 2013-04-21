<?php include "templates/include/header.php" ?>

<div id="adminHeader">
    <p>You are logged in as <b><?php echo $user ?></b>. <a href= "logout">Log out</a></p>
</div>

<form action="editQuesion=<?php echo $question->id ?>" method ='POST'>
    <table style="width:1100px" border="1" align="center">
        <tr>
            <th align="center"width="500"> Question No.</th>
            <th width="200" align="center">Question</th>
            <th width="200" align="center">Order</th>
        </tr>
    <table style="width:1100px" border="1" align="center">
        <tr><th align="center"width="500" >Answer</th>
            <th width="200" align="center">Order</th>
            <th width="200" align="center">Last Update</th>
            <th width="200" align="center" colspan="2">Actions</th>

            <?php foreach ($ans as $list) { ?>

            <tr>
                <td width="500"><input type="text" size ="50" name="answer" value="<?php echo $list->answer ?>"/></td>
                <td width="200"><input type="text" size ="5" name="order" value="<?php echo $list->order ?>"/></td>
                <td width="200"><?php echo $list->lastUpdate ?></td>
                <td width="100"><a href="editQuesion=<?php echo $list->id ?>">Edit</a></td>
                <td width="100"><a href="deleteAdmin=<?php echo $list->id ?>" onclick="return confirm('Delete This Question?')">Delete</a></td>
            </tr>
    </form>
<?php } ?>

</table>

<p align="center"><?php echo $total ?> Answer<?php echo ( $total != 1 ) ? 's' : '' ?> in total.

    <a href="newAnswer">Add Answer</a></p>

<?php include "templates/include/footer.php" ?>

