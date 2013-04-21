<!DOCTYPE html>

<html lang="zh-HK">

    <head>
        <meta charset="utf-8" />
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <br>
        <h1 align ="center">
            <?php echo $title; ?>
        </h1>
        <p align ="center">
            <?php echo $heading; ?>
        </p>

        <form id ="next" action = "../question"> 
            <center><input type ="submit" id ="next" value="Next"></center>
        </form>
        <br>
        <div id="footer" valign ="buttom">
            <a href="../login&null"/>admin site</a>
        </div>
</body>
</html>