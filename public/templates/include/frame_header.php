<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script language = "javascript" src = "http://code.jquery.com/jquery-1.9.1.js"></script>
        <script language = "javascript" src = "/new1/js/script.js"></script>
        <script>
            function confirmDelete() {
                if (confirm("Are you sure you want to delete")) {
                    parent.sub_frame.location = 'about:blank';
                }
            }</script>
        <link href="/new1/css/style.css" media="all" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id ="sub_frame_header">
            <h4><?php echo htmlspecialchars($pageHeader) ?> </h4>
        </div>