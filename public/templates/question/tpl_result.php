<!DOCTYPE html>
<html lang="zh-HK">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $header; ?></title>
    </head>
    
    <body>
        <h1 align ="center"><?php echo $title; ?></h1>
        <table align="center" width="500">
            <tr>
                <th>
                    <h3>你屬於 <?php echo $type; ?></h3>
                </th>
            </tr>
            <tr>
                <td>
                    <h5><?php echo $content; ?></h5>
                </td>
                
            </tr>
        </table>
        <table align ="center"> 
            <?php foreach ($c as $c) {?>
              <?php  if ($c == 1) {?>
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
                                <?php foreach ($stat[1] as $result) { ?>
                                    <tr>
                                        <td width="200" ><?php echo $result['Type'] ?></th>
                                        <td width="50" align="center"><?php echo $result['Frequency'] ?></th>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td align="center">
                            <img src= <?php echo $URL[1] ?> >
                        </td>
                    </tr>
            <?php }?>
                    
                    <?php if ($c == 2) { ?>
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
                                <?php foreach ($stat[2] as $result) { ?>
                                    <tr>
                                        <td width="200" ><?php echo $result['Type'] ?></th>
                                        <td width="50" ><?php echo $result['gender'] ?></th>
                                        <td width="50" align="center"><?php echo $result['Frequency'] ?></th>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td align="center">
                            <img src= <?php echo $URL[2] ?> >
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($c == 3) { ?>
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
                                <?php foreach ($stat[3] as $result) { ?>
                                    <tr>
                                        <td width="200" ><?php echo $result['type'] ?></th>
                                        <td width="50" ><?php echo $result['age'] ?></th>
                                        <td width="50" align="center"><?php echo $result['Frequency'] ?></th>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td align="center">
                            <img src= <?php echo $URL[3] ?> >
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($c == 4) { ?>
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
                                <?php foreach ($stat[4] as $ans) { ?>
                                    <tr>
                                        <td width="400" ><?php echo $ans['Answer'] ?></th>
                                        <td width="50" align="center"><?php echo $ans['Frequency'] ?></th>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td align="center">
                            <img src= <?php echo $URL[4] ?> >
                        </td>
                    </tr>
                    <tr>  </tr>
                <?php }?>
                <?php if ($c == 5) { ?>
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
                                <?php foreach ($stat[5] as $freq) { ?>
                                    <tr>
                                        <td width="50" ><?php echo $freq['seq'] ?></td>
                                        <td width="300" ><?php echo $freq['question'] ?></td>
                                        <td width="200" ><?php echo $freq['answer'] ?></td>
                                        <td width="50" align="center"><?php echo $freq['Frequency'] ?></td>
                                    </tr>
                                <?php } ?>
                            </table>  
                        </td>
                    </tr>
                <?php }} ?>
        </table>
    </body>
</html>