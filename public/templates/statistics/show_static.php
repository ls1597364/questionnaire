<?php include "templates/include/mainframe_header.php" ?>

<div id="statisticTable">
    <form action="changeShowChart" method='POST'>
        <table align ="center">
            <tr>
                <td>
                    <table style="width:400px" border="1" align="center">
                        <tr>
                            <th colspan='2'>
                                至今參與問卷的Facebook用戶量
                            </th>
                            <td width="50" align="center"><?php echo $fbuser ?></th>
                        </tr>
                    </table> 
                </td>
            </tr>

            <tr>
                <td valign="center">
                    <table style="width:250px" border="1" align="center">
                        <tr>
                            <th colspan='2' >
                                各結果的次數分佈
                            </th>
                        </tr>
                        <tr>
                            <th align="center" width="300" >類型</th>
                            <th width="50" align="center">次數</th>
                        </tr>
                        <?php foreach ($resultfreq as $result) { ?>
                            <tr>
                                <td width="200" ><?php echo $result['Type'] ?></th>
                                <td width="50" align="center"><?php echo $result['Frequency'] ?></th>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan='2' align="center">
                                <input type="checkbox" name="chart[]" value="1" <?php
                                foreach ($chart as $ch) {
                                    if ($ch->display == 1 && $ch->id == 1)
                                        echo "checked";
                                }
                                ?>/>Show On the result page.<br>
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="center">
                    <img src= <?php echo $URL1 ?> >
                </td>
            </tr>

            <tr>
                <td valign="center">
                    <table style="width:250px" border="1" align="center">
                        <tr>
                            <th colspan='3'>
                                各結果的男女分佈
                            </th>
                        </tr>
                        <tr>
                            <th align="center" width="200" >類型</th>
                            <th align="center" width="50" >性別</th>
                            <th width="50" align="center">次數</th>
                        </tr>
<?php foreach ($genderNresult as $result) { ?>
                            <tr>
                                <td width="200" ><?php echo $result['Type'] ?></td>
                                <td width="50" ><?php echo $result['gender'] ?></td>
                                <td width="50" align="center"><?php echo $result['Frequency'] ?></td>
                            </tr>
<?php } ?>
                        <tr>
                            <td colspan='3' align="center">
                                <input type="checkbox" name="chart[]" value="2" <?php
                                       foreach ($chart as $ch) {
                                           if ($ch->display == 1 && $ch->id == 2)
                                               echo "checked";
                                       }
                                       ?>>Show On the result page.<br>
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="center">
                    <img src= <?php echo $URL2 ?> >
                </td>
            </tr>

            <tr>
                <td valign="center">
                    <table style="width:250px" border="1" align="center">
                        <tr>
                            <th colspan='3'>
                                各結果的年齡分佈
                            </th>
                        </tr>
                        <tr>
                            <th align="center" width="200" >類型</th>
                            <th align="center" width="50" >年齡</th>
                            <th width="50" align="center">次數</th>
                        </tr>
<?php foreach ($ageresult as $result) { ?>
                            <tr>
                                <td width="200" ><?php echo $result['type'] ?></td>
                                <td width="50" ><?php echo $result['age'] ?></td>
                                <td width="50" align="center"><?php echo $result['Frequency'] ?></td>
                            </tr>
                                <?php } ?>
                        <tr>
                            <td colspan='3' align="center">
                                <input type="checkbox" name="chart[]" value="3" <?php
                                foreach ($chart as $ch) {
                                    if ($ch->display == 1 && $ch->id == 3)
                                        echo "checked";
                                }
                                ?>>Show On the result page.<br>
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="center">
                    <img src= <?php echo $URL3 ?> >
                </td>
            </tr>

            <tr> 
                <td>
                    <table style="width:450px" border="1" align="center">
                        <tr>
                            <th colspan='2'>
                                各答案被選擇的次數
                            </th>
                        </tr>
                        <tr>
                            <th align="center" width="400" >答案</th>
                            <th width="50" align="center">次數</th>
                        </tr>
<?php foreach ($ansfreq as $ans) { ?>
                            <tr>
                                <td width="400" ><?php echo $ans['Answer'] ?></td>
                                <td width="50" align="center"><?php echo $ans['Frequency'] ?></td>
                            </tr>
                                       <?php } ?>
                        <tr>
                            <td colspan='2' align="center">
                                <input type="checkbox" name="chart[]" value="4" <?php
                                       foreach ($chart as $ch) {
                                           if ($ch->display == 1 && $ch->id == 4)
                                               echo "checked";
                                       }
                                       ?>>Show On the result page.<br>
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="center">
                    <img src= <?php echo $URL4 ?> >
                </td>
            </tr>
            <tr>  </tr>
            <tr>
                <td colspan="2" valign="center">
                    <table style="width:600px" border="1" align="center">
                        <tr>
                            <th colspan='4'>
                                各題目被選擇次數最多的答案
                            </th>
                        </tr>
                        <tr>
                            <th align="center" width="50" >題號</th>
                            <th align="center" width="300" >題目</th>
                            <th align="center" width="200" >答案</th>
                            <th width="50" align="center">次數</th>
                        </tr>
<?php foreach ($mostfreqAns as $freq) { ?>
                            <tr>
                                <td width="50" ><?php echo $freq['seq'] ?></td>
                                <td width="300" ><?php echo $freq['question'] ?></td>
                                <td width="200" ><?php echo $freq['answer'] ?></td>
                                <td width="50" align="center"><?php echo $freq['Frequency'] ?></td>
                            </tr>
<?php } ?>
                        <tr>
                            <td colspan='4' align="center">
                                <input type="checkbox" name="chart[]" value="5" <?php
foreach ($chart as $ch) {
    if ($ch->display == 1 && $ch->id == 5)
        echo "checked";
}
?>>Show On the result page.<br>
                            </td>
                        </tr>
                    </table>  
                </td>
            </tr>
            <td align='left' colspan='2'>
                <input type="submit" id="submit" value="Save Changes"/>
                <input type="submit" id="cancel" value="Cancel"/>
            </td>
        </table>
    </form>
</div>
<?php include "templates/include/frame_footer.php" ?>