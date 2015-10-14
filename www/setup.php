<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Multi-Message Gateway :: Configuration</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
  <body>
    
    <div class="row">
      <div class="large-12 columns">
        <h1>Multi-Message Gateway Setup</h1>
      </div>
    </div>
    
    <div class="row">
      <div class="large-12 columns">
        <div class="panel">
          <h3>Thank you for choosing MMG! </h3>
          <p>To maximise this demo-unit, please configure the messaging options here.</p>
          <div class="row">
            <div class="large-4 medium-4 columns">
              <label>Message Center</label>
              <input type="text" placeholder="SMSC Number" value="+6594998888" />
            </div>
            <div class="large-4 medium-4 columns">
              <label>Duty Number</label>
              <input type="text" placeholder="+65" value="+65"/>
            </div>
            <div class="large-4 medium-4 columns">
	      <label>Last Incoming Message From</label>
              <input type="text" placeholder="+65xxxxx" value="+65"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="large-6 medium-6 columns">
        <div class="panel">
          <div class="row">
            <div class="large-6 medium-6 columns">
              <h4>SMS Options</h4>
            </div>
          </div>
          <div class="row">
            <div class="large-12 medium-12 columns">
              <p>Registered numbers</p>
	<ul class=mtree>
	<?php
	$numbers = file_get_contents('/usr/local/src/dutyPhone/staffnumber.txt');
	foreach(preg_split("/((\r?\n)|(\r\n?))/", $numbers) as $line) {
		if ($line != "") {
			echo '<li>'.strtok($line, "\t ,");
			$type = strtok("\t");
			if ($type == 'S') {
				echo '(Supervisor)';
			} else {
				echo '(Staff)';
			}
			echo '</li>';
		}
	}
	?>
	</ul>
              <a href="#" class="small radius button">Add Supervisor Number</a><br/>
              <a href="#" class="small radius button">Add Staff Number</a><br/>
            </div>
          </div>
        </div>
      </div>

      <div class="large-6 medium-6 columns">
        <div class="panel">
          <div class="row">
            <div class="large-12 medium-12 columns">
              <h4>WhatsApp Options</h4>
            </div>
          </div>
          <div class="row">
            <div class="large-12 medium-12 columns">
            <p>Configure your GroupChat ID here.</p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="large-12 medium-12 columns">
        <div class="panel">
        <h3>Message Log</h3>
        <pre>
        <?php echo file_get_contents('/usr/local/src/logs/sms-messages.txt'); ?>
        </pre>
        </div>
      </div>
    </div>

    <script src="js/velocity.js"></script>
    <script src="js/mtree.js"></script>
    
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
