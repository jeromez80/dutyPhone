<?php

//### add standard includes#####
include("includes/main.inc.php");

//### login check #########
if(!isAppLoggedIn()){
  header('Location: login.php');
}

$config = new ConfigData();
?>
<!doctype html>
<html class="no-js" lang="en">
<?php include("header.php"); ?>
<body>
    
    <div class="row">
      <div class="large-12 columns">
        <h1>Smart-Message Gateway Setup</h1>
      </div>
    </div>
<!-- left columns tabs menu --------->

<?php include("tabs.php"); ?>

<div class="tabs-content">
  <div class="content active" id="panelNC">
   	<?php include("tabnetworkconfiguration.php"); ?> 
  </div>
  
  <div class="content" id="panelRN">
   	<?php include("tabregisterednumber.php"); ?> 
  </div>
  
  <div class="content" id="panelMN">
  	<?php include("tabMobileNetwork.php"); ?> 
  </div>
  
  <div class="content" id="panelWA">
   	<?php include("tabwhatsapp.php"); ?> 
  </div>
  
  <div class="content" id="panelLogsSysPage">
 	<p> syspage </p> 
 </div>
   
  <div class="content" id="panelLogsWAPage">
 	<p> wa page </p>
  </div>
   
  <div class="content" id="panelLogsSMSPage">
 	<?php include("tabsmslogs.php"); ?>
  </div>

</div>


<!------------ content of pages ----------->
<!----------- 1) network configuration ------->
 <script src="js/vendor/jquery.js"></script>
  <script src="js/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>

</body>
</html>

