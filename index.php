<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>PHP SDK Test</title>
		<style>
			* {
				padding: 0;
				margin: 0;
				color: #444;
			}
			body {
				font-size: 12px;
				font-family:arial;
				background: #eee;
			}
			#wrapper {
				border: 1px solid #ddd;
				margin: 10px auto;
				padding: 20px;
				width: 740px;
				background: #fff;
				border-radius: 10px;
				box-shadow: 0px 1px 4px #ccc;
			}
			section {
				border: 1px solid #ddd;
				padding: 10px;
				cursor: pointer;
			}
			article {
				width: 100%;
			}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<h1>PHP SDK (3.0.0)</h1>
			<p>Click the sections to see some code run...</p>
			<br>
			<section>
				<h1><span>&plus;</span> Basic Setup</h1>
				<article>
					<p>Loading the bootstrap...</p>
					<?php
						require_once "bootstrap.php";
					?>		
				</article>		
			</section>
			<section>
				<h1><span>&plus;</span> Segments Test</h1>
				<article>
					<p>Loading the Segments library...</p>
					<?php
						require_once "library/Segments.php";
						$segments = new Segments();
						//_d($segments->get_all_segments());
						//_d($segments->errors->get_error_count());
					?>		
				</article>			
			</section>
			<section>
				<h1><span>&plus;</span> Offers</h1>
				<article>
					<p>Nothing going on here yet...</p>
				</article>
			</section>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script>
			$(document).ready(function() {
				$('article', 'section').hide();
				
				$('section').click(function(){
					var elm = $('h1 span', this);
					if (elm.html() == '+') {
						elm.html('&minus;');
					} else {
						elm.html('&plus;');
					}
					
					$('article', this).slideToggle(500);
				});				
			});
		</script>
	</body>
</html>



<?php

/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/


//simple var_dump utility that lets me output to the screen...
function _d($x, $die = FALSE)
{
   echo "<pre>";
   var_dump($x);
   if ($die)
   {
      die();
   }   
   echo "</pre>";
}