<?php
use IHRISSYNC\ihrisSync;

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $sync = new IHRISSYNC();
        $sync->setMysqlConnection("hardevhim.ct.apelon.com", "ihris_manage", "apelon1", "ihris_manage");
        
        ?>
    </body>
</html>
