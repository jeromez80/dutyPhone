<?php
require_once(__DIR__."/functions/initialise.php");
require_once(__DIR__."/header.php");
require_once(__DIR__."/functions/syslog.php");

//if(!isAppLoggedIn()){
  //header('Location: login.php');
//}
?>

<div class="row">
        <div class="large-10 medium-10 columns">
                <div class="panel">
                        <h3>Incoming Emails</h3>

                        <?php
                                $query = get_inEmails();
                        ?>
                                <table id="sortTable" class="display" cellspacing="0" width="100%">
                                        <thead>
                                                <tr>
                                                        <th id="logtimestamp">Date</th>
                                                        <th>From</th>
                                                        <th>Subject</th>
                                                        <th>Message</th>
                                                </tr>
                                        </thead>
                                        <tbody>

                                        <?php   while ($row=mysql_fetch_array($query)) {
                                        ?>
                                                        <tr>
                                                                <td><?php echo $row[0];?></td>
                                                                <td><?php echo $row[1];?></td>
                                                                <td><?php echo $row[2];?></td>
                                                                <td><?php echo $row[3];?></td>
                                                        </tr>

                                        <?php   } ?>
                                        </tbody>
                                </table>

                        <form action="#" method="POST"><input class="small radius button" type="submit" name="nothing" value="Refresh"></form>
                </div>
      </div>
</div>
