<?php include "templates/include/header.php" ?>

<br><br><br><br><br><br><br><br>
<div id= "loginForm" align="center">
    <form action="login" method="POST" >
        <p><span id="error"><?php echo $error; ?></span></p>
        <label for="username">Username</label>
        <input type="text" name="username" id="username"/><br><br>

        <label for="password">Password&nbsp;</label>
        <input type="password" name="password" id="password"/>

        <div class="buttons"><br>
            <input type="submit" name="Login" value="Login" />
            <input type="reset" name="Reset" value="Reset" />
        </div>
    </form>
</div>
<?php include "templates/include/footer.php" ?>