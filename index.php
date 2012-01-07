<!doctype html>
<html>
<?php ini_set('memory_limit', '512M'); ?>
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
			
			section section {
				border: 1px solid #ddd;
			}
			section section.alt {
				background: #eee;
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
					<p>The <code>_autoload()</code> function should take care of loading everything else for you...</p>
				</article>		
			</section>
			<section>
				<h1><span>&plus;</span> Support</h1>
				<article>
					<p>PHP Version (<?php print PHP_VERSION;?>): 
					<?php if (version_compare(PHP_VERSION, "5.3.0", ">=" )): ?>
						<span style='color: green;'>Your PHP version does support Namespaces.</span>	
					<?php else: ?>
						<span style='color: red;'>Your PHP version does not support Namespaces.</span>	
					<?php endif; ?><p>Curl Support: 
					<?php if (function_exists("curl_init")): ?>
						<span style='color: green;'>Yes</span>	
					<?php else: ?>
						<span style='color: red;'>No</span>	
					<?php endif; ?>
					</p>
				</article>		
			</section>
			<section>
				<h1><span>&plus;</span> Segments Test</h1>
				<article>
					<section class="">
						<p><strong>Load up the segments: </strong> <code>$segments = new Segments();</code></p>
						<?php $segments = new Segments(); ?>
						<p>loaded...</p>
					</section>
					<section class="alt">
						<p><strong>Count the errors (if any): </strong> <code>$segments->errors->get_error_count();</code></p>
						<?php _d($segments->errors->get_error_count()); ?>
					</section>
					<section class="">
						<p><strong>What api version is this? </strong> <code>$segments->version;</code></p>
						<?php _d($segments->version); ?>
					</section>		
					<section class="alt">
						<p><strong>Get all the inactive segments: </strong> <code>$segments->get_inactive_segments();</code></p>
						<?php _d($segments->get_inactive_segments()); ?>
					</section>		
					<section class="">
						<p><strong>Get all the active segments</strong> <code>$segments->get_active_segments();</code></p>
						<?php _d($segments->get_active_segments()); ?>
					</section>	
					<section class="alt">
						<p><strong>Get all based on X: </strong> <code>$segments->get_segments_where('description', '#region#');</code></p>
						<?php _d($segments->get_segments_where('description', '#region#')); ?>
					</section>																		
				</article>			
			</section>
			<section>
				<h1><span>&plus;</span> Offers</h1>
				<article>
					<section class="">
						<p><strong>Load up the Offers: </strong> <code>$offers = new Offers();</code></p>
						<?php $offers = new Offers(); ?>
						<p>loaded...</p>
					</section>
					<section class="alt">
						<p><strong>Count the errors (if any): </strong> <code>$offers->errors->get_error_count();</code></p>
						<?php _d($offers->errors->get_error_count()); ?>
						<p><?= $offers->errors->get_error_count(); ?></p>
					</section>
					<section class="">
						<p><strong>What api version is this? </strong> <code>$offers->version;</code></p>
						<?php _d($offers->version); ?>
						<p><?= $offers->version ?></p>
					</section>		
					<section class="alt">
						<p><strong>Get all the offers: </strong> <code>$offers->get_all_offers();</code></p>
						<?php //_d($offers->get_all_offers()); ?>
					</section>
				</article>
			</section>
			<section>
				<h1><span>&plus;</span> Offer</h1>
				<article>
					<section class="">
						<p><strong>Load up the Offer: </strong> <code>$offer = new Offer();</code></p>
						<?php $offer = new Offer('4527'); ?>
						<p>loaded...</p>
					</section>
					<section class="alt">
						<p><strong>Count the errors (if any): </strong> <code>$offer->errors->get_error_count();</code></p>
						<?php _d($offer->errors->get_error_count()); ?>
						<p><?= $offer->errors->get_error_count(); ?></p>
					</section>
					<section class="">
						<p><strong>What api version is this? </strong> <code>$offer->version;</code></p>
						<?php _d($offer->version); ?>
						<p><?= $offer->version ?></p>
					</section>		
					<section class="alt">
						<p><strong>Get all the offer details: </strong> <code>$offer->get_offer();</code></p>
						<?php _d($offer->get_offer()); ?>
					</section>																	
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
