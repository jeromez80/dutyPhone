	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Smart-Message Gateway :: Configuration</title>
		<link rel="stylesheet" href="css/foundation.css" />
		<link rel="stylesheet" href="css/app.css" />
		<script src="js/vendor/modernizr.js"></script>
	 	<script src="js/velocity.js"></script>
    		<script src="js/mtree.js"></script>
		<script src="js/jquery.min.js"></script>

		<!--  scripts for dataTables -->		
		<link rel="stylesheet" href="css/dataTables.foundation.min.css" />
		<link rel="stylesheet" href="css/buttons.foundation.min.css" />
		<link rel="stylesheet" href="css/jquery.dataTables.min.css" />
		<script src="js/dataTables.foundation.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/buttons.foundation.min.js"></script>
		<script src="js/dataTables.buttons.min.js"></script>
		

		<!--	function for tabs collapse. -->
		
		<!-- leave it here. will put into another file later on. -->
		<script>
			$(document).ready(function(){
    				$("#panelLogs").click(function(){
        				$("#panelLogsSys").toggle();
					$("#panelLogsSMS").toggle();
					$("#panelLogsWA").toggle();
					$("#panelLogsMG").toggle();
	
    				});
			});


			$(document).ready(function(){
                                $("#panelNC").click(function(){

					$("#panelLogsSys").removeClass('active');
                                        $("#panelLogsSMS").removeClass('active');
                                        $("#panelLogsWA").removeClass('active');
                                        $("#panelLogsMG").removeClass('active');
                                });

				
				$("#panelRN").click(function(){
                                
					$("#panelLogsSys").removeClass('active');
                                        $("#panelLogsSMS").removeClass('active');
                                        $("#panelLogsWA").removeClass('active');
                                        $("#panelLogsMG").removeClass('active');
				});

 				$("#panelMN").click(function(){
                                	$("#panelLogsSys").removeClass('active');
                                        $("#panelLogsSMS").removeClass('active');
                                        $("#panelLogsWA").removeClass('active');
                                        $("#panelLogsMG").removeClass('active');

				});
				
				
                                $("#panelWA").click(function(){
                                
					$("#panelLogsSys").removeClass('active');
                                        $("#panelLogsSMS").removeClass('active');
                                        $("#panelLogsWA").removeClass('active');
                                        $("#panelLogsMG").removeClass('active');
				});

				 $("#panelLOff").click(function(){
                                        $(location).attr('href','logout.php');
                                });



                        });


			$(document).ready(function() {
        			$('#sortTable').DataTable( {
					"order": [[ 0, "desc" ]]
			
				} );		
		
        		} );
	       </script>
	</head>
