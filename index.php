<!-- Contributed by Tim Huynh Le for MicroHealth, LLC., under the GN Affero General Public License 3.0-->
<!DOCTYPE html>


<?php

/*
 * This is an example file for a public interface and a bookmarklet. It
 * is provided so you can build from it and customize to suit your needs.
 * It's not really part of the project. Don't submit feature requests 
 * about this file. It's _your_ job to make it what you need it to be :)
 *
 * Rename to .php
 *
 */

// Start YOURLS engine
require_once( dirname(__FILE__).'/includes/load-yourls.php' );

// Change this to match the URL of your public interface. Something like: http://yoursite.com/index.php
$page = YOURLS_SITE . '/index.php' ;

// Part to be executed if FORM has been submitted
if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ) {

	// Get parameters -- they will all be sanitized in yourls_add_new_link()
	$url     = $_REQUEST['url'];
	$keyword = isset( $_REQUEST['keyword'] ) ? $_REQUEST['keyword'] : '' ;
	$title   = isset( $_REQUEST['title'] ) ?  $_REQUEST['title'] : '' ;
	$text    = isset( $_REQUEST['text'] ) ?  $_REQUEST['text'] : '' ;

	// Create short URL, receive array $return with various information
	$return  = yourls_add_new_link( $url, $keyword, $title );
	
	$shorturl = isset( $return['shorturl'] ) ? $return['shorturl'] : '';
	$message  = isset( $return['message'] ) ? $return['message'] : '';
	$title    = isset( $return['title'] ) ? $return['title'] : '';
	
	// Stop here if bookmarklet with a JSON callback function ("instant" bookmarklets)
	if( isset( $_GET['jsonp'] ) && $_GET['jsonp'] == 'yourls' ) {
		$short = $return['shorturl'] ? $return['shorturl'] : '';
		$message = "Short URL (Ctrl+C to copy)";
		header('Content-type: application/json');
		echo yourls_apply_filter( 'bookmarklet_jsonp', "yourls_callback({'short_url':'$short','message':'$message'});" );
		
		die();
	}
}

// Insert <head> markup and all CSS & JS files
yourls_html_head();

// Display title
echo "<div id='logo'><a href='http://microh.us'><img src='./images/logo.png'></a></div>\n";


// Part to be executed if FORM has been submitted
if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ) {

	// Display result message of short link creation
	if( isset( $message ) ) {
		echo "<div></div>";
	}

	// Include the Copy box and the Quick Share box
	yourls_share_box( $url, $shorturl, $title, $text );
	
	// Initialize clipboard -- requires js/share.js and js/jquery.zclip.min.js to be properly loaded in the <head>
	echo <<<JS
	<script>
	init_clipboard();
	</script>
JS;

// Part to be executed when no form has been submitted
} else {

		$site = YOURLS_SITE;
		$humver = $ayah->getPublisherHTML();
		// Display the form
		echo <<<HTML
		<form method="post" action="" target="_parent">
		<div style="text-align:center;">
                <div style="max-width: 540px;display: inline-block;text-align: right;"><input width="500" placeholder="Paste or enter a hyperlink here" id="texturl" type="text" class="text" name="url"  />
                    <div id="optionsc">
                      <div id="optionsa" onclick="optionshow()">Options</div>
                      <div id="optionsb"><label>Custom URL: $site/<input type="text" class="text" name="keyword" /></label></div>
                    </div></div>
                <div style="max-width: 142px;display: inline-block;vertical-align: top;"> 

             $humver
<input type="submit" class="button primary" value="Shorten" name="ssubmit" id="sbutton" /></div></div>
		</form>	
HTML;

}

?>





<?php

// Display page footer
yourls_html_footer();	
