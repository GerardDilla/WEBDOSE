<html>
    <head>
        <!-- <title>Send Mail</title> -->
    </head>
    <body>
        <p>
        Hi <?php echo $student['First_Name'] . ' ' . $student['Middle_Name'] . ' ' . $student['Last_Name'];?> Here is the info you requested. <a href="<?php echo $link; ?>" target="_blank"><?php echo 'Click here to download your SOA'; ?></a> 
        </p>
    </body>
</html>