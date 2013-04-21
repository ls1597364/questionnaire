<!DOCTYPE html>

<html lang="zh-HK">

    <head>
        <meta charset="utf-8" />
        <title><?php echo $header; ?></title>
    </head>
    <body>
        <br>
        <h1 align ="center"><?php echo $title; ?></h1>
        <br><br>
        <form name ='form' method ='post' action ='getResult'>
            <?php
            $i = 1;
            $j = 1;
            foreach ($questions as $questions) {
                echo "Q";
                echo $i . ".";
                echo $questions->question . "<br><br>";
                foreach ($ans[$questions->seq - 1] as $answers) {
                    $option = 'option_' . $i;
                    echo "<Input type = 'Radio' Name ='$option' value= '$answers->id'>";
                    echo $answers->answer . "<br><br>";
                    $j++;
                }
                $i++;
            }

            echo "<br>";
            echo "<Input type = 'Reset' Name = 'Reset' VALUE = 'Reset' >";
            echo "<Input type = 'Submit' Name = 'Submit1' VALUE = 'Sumbit' >";
            ?>
        </form>
        <br>
    </body>
</html>