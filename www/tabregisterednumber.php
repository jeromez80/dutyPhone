<?php
?>

<div class="row">
      		<div class="large-10 medium-10 columns">
        		<div class="panel">
          			<div class="row">
            				<div class="large-12 medium-12 columns">
              					<h4>SMS Options</h4>
            				</div>
          			</div>
          
				<div class="row">
            				<div class="large-12 medium-12 columns">
              					<p>Registered numbers</p>
        					<ul class=mtree>
                					<?php
                        					$res55  = mysql_query("SELECT * FROM `superviser_number`  ") or die(mysql_error());
                        				
								if(mysql_num_rows($res55) > 0){
                                					while ($dao = mysql_fetch_assoc($res55)){
                                        
										if($dao['number_type']=='S'){
                                                					$number_type = 'Supervisor';
                                        					}else{
                                                					$number_type = 'Staff';
                                        					}//end if-else

                                        					echo  '<li id="li_'.$dao['id'].'">'.$dao['number'].'&nbsp;&nbsp;'.$number_type.'&nbsp;&nbsp;<a href="javascript:void(0)" rel="'.$dao['id'].'" class="small radius button delete_no" style="background-color:red;">Delete</a></li>';
                                					} //end while-loop
                        					}//end if
                					?>
						</ul>
              

						<a href="javascript:void(0)" class="small radius button superviser_number">Add Supervisor Number</a><br/>
                          
						<form name="f2" method="post" action="#">
                           				<input type="text" class="superviser" name="superviser_number" placeholder="Superviser Number" value="" style="display:none;">
                           				<input type="hidden" name="number_type" value="S">
                           				<input type="submit" class="small radius button superviser" value="submit" name="submit2" style="display:none;">
                          			</form>
              
						<a href="javascript:void(0)" class="staff_data small radius button">Add Staff Number</a><br/>
                          
						<form name="f2" method="post" action="#">
                           				<input type="text" class="staff_data_input" name="staff_number" placeholder="Staff Number" value="" style="display:none;">
                           				<input type="hidden" name="number_type" value="D">
                           				<input type="submit" class="small radius button staff_data_input" value="submit" name="submit3" style="display:none;">
                          			</form>
            				</div>
          			</div>
        		</div>
      		</div>
</div>


