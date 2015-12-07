<div class="row">
	<div class="large-10 medium-10 columns">
        	<div class="panel">
        		<h3>Message Log</h3>
			<?php
				$select = "select timestamp, sender, receiver, message from `messages` order by id desc";
				$query = mysql_query($select);

				while($row=mysql_fetch_array($query))
				{
        				echo '
                				<div class="panel">
                					<div class="row">
                						<div class="large-4 medium-4 columns"><label>Date: '.$row[0].'</label></div>
                						<div class="large-4 medium-4 columns"><label>From: '.$row[1].'</label></div>
                						<div class="large-4 medium-4 columns"><label>To: '.$row[2].'</label></div>
                					</div>
							<div class="row">
                						<div class="large-12 medium-12 columns"><label>Message: '.$row[3].'</label></div>
                					</div>
						</div> ';
				}

			?>
        
			<form action="#" method="POST"><input class="small radius button" type="submit" name="nothing" value="Refresh"></form>
        	</div>
      </div>
</div>

