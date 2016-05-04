<?php
require_once(__DIR__."/functions/initialise.php");
require_once(__DIR__."/functions/keywordfilters.php");

if(!isAppLoggedIn()){
  header('Location: login.php');
}
?>


<div class="row">
   <div class="large-10 columns">
        <div class="panel">
          	<h3>Keyword Filters</h3>
          	<form name="keywordfilters" method="post" action="#">
			<p>Configure keywords and corresponding actions that will be applied to all your incoming messages. This demo unit allows you to create a one keyword filter to be sent to a separate set of mobile numbers. There is no limit to the number of keyword filters on a commercial unit.</p>
			<div class="row">
				<div class="large-12 medium-12 columns">
					<div class="large-6 medium-6 columns">
						<p>Default Filter: All email messages.</p>
					</div>
					<div class="large-6 medium-6 columns">
						<label>Recipient Mobile Numbers (comma separated): </label><input type=text name='filter0number' value='<?php echo getFilterNumber(1); ?>'>
            				</div>
				</div>

				<div class="large-12 medium-12 columns">
					<div class="large-6 medium-6 columns">
						<p>Filter 1 Keyword: <input type='text' name='filter1keyword' value='<?php echo getFilterKeyword(2); ?>'></p>
            				</div>
					<div class="large-6 medium-6 columns">
						<label>Recipient Mobile Numbers (comma separated): </label><input type=text name='filter1number' value='<?php echo getFilterNumber(2); ?>'>
            				</div>
				</div>
          		</div>
                
			<div class="row">
                        	<div class="panel" style="border:none;">
                                	<input type="submit" class="small radius button" value="Save Filters" name="btnSaveFilters">
                        	</div>
			</div>
                   
		</form>
       	  </div>
    </div>
</div>
