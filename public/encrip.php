<html>
    <head></head>
    <body>
        <?php
            $data = base64_encode("RES FULL API Institut ASIA");
            //echo $data;
        ?>
        <form action="login/ul?req=UkVTIEZVTEwgQVBJIEluc3RpdHV0IEFTSUE=&un=wildan&up=password" method="get">
            <input type="hidden" name="req" placeholder="User Name" value="UkVTIEZVTEwgQVBJIEluc3RpdHV0IEFTSUE=" />
            <input type="text" name="un" placeholder="User Name" />
            <input type="password" name="up" placeholder="User Password" />
            
            <button type="submit">Login</button>
        </form>
    </body>
</html>