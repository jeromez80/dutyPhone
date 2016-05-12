<?php

//### add standard includes#####
require_once(__DIR__."/functions/initialise.php");

//### login check #########
if(!isAppLoggedIn()){
  header('Location: login.php');
}

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
<!-- Left columns tabs menu --------->
<div>
<?php include("tabs.php"); ?>
</div>
<!--- Content ------------------->
<?php $tabNC='active';?>
<?php if ($_POST['refreshEmailLogs']!='') { $tabEmail='active'; $tabNC='';} ?>
<?php if ($_POST['refreshSMS']!='') { $tabSMS='active'; $tabNC='';} ?>
<?php if ($_POST['btnSaveFilters']!='') { $tabKW='active'; $tabNC='';} ?>
<div class="tabs-content">
  <div class="content <?php echo $tabNC; ?>" id="panelNC">
        <?php include("tabnetworkconfig.php"); ?>
  </div>

  <div class="content" id="panelMN">
        <?php include("tabmobilenetwork.php"); ?>
  </div>

  <div class="content" id="panelSend">
        <?php include("tabsendsms.php"); ?>
  </div>

<!---
  <div class="content" id="panelRN">
        <?php include("tabregisterednumber.php"); ?>
  </div>

  <div class="content" id="panelWA">
        <?php include("tabsocial.php"); ?>
  </div>
--->
  <div class="content <?php echo $tabKW; ?>" id="panelFilters">
        <?php include("tabkeywordfilters.php"); ?>
  </div>

  <div class="content" id="panelLogsSysPage">
	<?php include("tabsyslogs.php"); ?>        
 </div>
<!----
  <div class="content" id="panelLogsWAPage">
        <?php include("tabsociallogs.php"); ?>
  </div>
--->
  <div class="content <?php echo $tabSMS; ?>" id="panelLogsSMSPage">
        <?php include("tabsmslogs.php"); ?>
  </div>

  <div class="content <?php echo $tabEmail; ?>" id="panelLogsEMPage">
        <?php include("tabemaillogs.php"); ?>
  </div>

  <div class="content" id="panelLogsMGPage">
        <?php include("tabdevicelogs.php"); ?>
  </div>

</div>
<!---  Must have these js added at the end for tabs to work ----->

<script src="js/foundation.min.js"></script>  
<script>
    $(document).foundation();
  </script>
</body>
</html>

