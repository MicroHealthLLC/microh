<?php

require_once( YOURLS_ABSPATH . '/includes/ayah.php' );
$ayah = new AYAH();

if (array_key_exists('ssubmit', $_POST))
{
        // Use the AYAH object to see if the user passed or failed the game.
        $score = $ayah->scoreResult();

        if ($score)
        {
        }
        else
        {
        }
}
?>
<?php

/**
 * Display <h1> header and logo
 *
 */
function yourls_html_logo() {
	yourls_do_action( 'pre_html_logo' );
	?>
<div id='logo'><a href='http://microh.us'><img src='../images/logo.png'></a></div>
	<?php
	yourls_do_action( 'html_logo' );
}

/**
 * Display HTML head and <body> tag
 *
 * @param string $context Context of the page (stats, index, infos, ...)
 * @param string $title HTML title of the page
 */
function yourls_html_head( $context = 'index', $title = '' ) {

	yourls_do_action( 'pre_html_head', $context, $title );
	
	// All components to false, except when specified true
	$share = $insert = $tablesorter = $tabs = $cal = $charts = false;
	
	// Load components as needed
	switch ( $context ) {
		case 'infos':
			$share = $tabs = $charts = true;
			break;
			
		case 'bookmark':
			$share = $insert = $tablesorter = true;
			break;
			
		case 'index':
			$insert = $tablesorter = $cal = $share = true;
			break;
			
		case 'plugins':
		case 'tools':
			$tablesorter = true;
			break;
		
		case 'install':
		case 'login':
		case 'new':
		case 'upgrade':
			break;
	}
	
	// Force no cache for all admin pages
	if( yourls_is_admin() && !headers_sent() ) {
		header( 'Expires: Thu, 23 Mar 1972 07:00:00 GMT' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );
		header( 'Pragma: no-cache' );
		yourls_do_action( 'admin_headers', $context, $title );
	}
	
	// Store page context in global object
	global $ydb;
	$ydb->context = $context;
	
	// Body class
	$bodyclass = yourls_apply_filter( 'bodyclass', '' );
	$bodyclass .= ( yourls_is_mobile_device() ? 'mobile' : 'desktop' );
	
	// Page title
	$_title = 'YOURLS &mdash; Your Own URL Shortener | ' . yourls_link();
	$title = $title ? $title . " &laquo; " . $_title : $_title;
	$title = yourls_apply_filter( 'html_title', $title, $context );
	
	?>
<!DOCTYPE html>

<html <?php yourls_html_language_attributes(); ?>>
<head>
	<title>MicroH.us</title>
	<link rel="shortcut icon" href="<?php yourls_favicon(); ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE-9"/>
	<meta name="author" content="Ozh RICHARD & Lester CHAN for http://yourls.org/" />
	<meta name="generator" content="YOURLS <?php echo YOURLS_VERSION ?>" />
	<meta name="description" content="Insert URL &laquo; YOURLS &raquo; Your Own URL Shortener' | <?php yourls_site_url(); ?>" />
	<script src="<?php yourls_site_url(); ?>/js/jquery-1.9.1.min.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<script src="<?php yourls_site_url(); ?>/js/common.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<script src="<?php yourls_site_url(); ?>/js/jquery.notifybar.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php yourls_site_url(); ?>/css/style.css?v=<?php echo YOURLS_VERSION; ?>" type="text/css" media="screen" />
	<?php if ( $tabs ) { ?>
		<link rel="stylesheet" href="<?php yourls_site_url(); ?>/css/infos.css?v=<?php echo YOURLS_VERSION; ?>" type="text/css" media="screen" />
		<script src="<?php yourls_site_url(); ?>/js/infos.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<?php } ?>
	<?php if ( $tablesorter ) { ?>
		<link rel="stylesheet" href="<?php yourls_site_url(); ?>/css/tablesorter.css?v=<?php echo YOURLS_VERSION; ?>" type="text/css" media="screen" />
		<script src="<?php yourls_site_url(); ?>/js/jquery.tablesorter.min.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<?php } ?>
	<?php if ( $insert ) { ?>
		<script src="<?php yourls_site_url(); ?>/js/insert.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<?php } ?>
	<?php if ( $share ) { ?>
		<link rel="stylesheet" href="<?php yourls_site_url(); ?>/css/share.css?v=<?php echo YOURLS_VERSION; ?>" type="text/css" media="screen" />
		<script src="<?php yourls_site_url(); ?>/js/share.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
		<script src="<?php yourls_site_url(); ?>/js/jquery.zclip.min.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<?php } ?>
	<?php if ( $cal ) { ?>
		<link rel="stylesheet" href="<?php yourls_site_url(); ?>/css/cal.css?v=<?php echo YOURLS_VERSION; ?>" type="text/css" media="screen" />
		<?php yourls_l10n_calendar_strings(); ?>
		<script src="<?php yourls_site_url(); ?>/js/jquery.cal.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<?php } ?>
	<?php if ( $charts ) { ?>
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">
					 google.load('visualization', '1.0', {'packages':['corechart', 'geochart']});
			</script>
	<?php } ?>
	<script type="text/javascript">
	//<![CDATA[
		var ajaxurl  = '<?php echo yourls_admin_url( 'admin-ajax.php' ); ?>';
		var zclipurl = '<?php yourls_site_url(); ?>/js/ZeroClipboard.swf';
	//]]>
	</script>
	<?php yourls_do_action( 'html_head', $context ); ?>
        <script>
        function optionshow() {optionarrow();
              var eszsb = document.getElementById('optionsb');
              if(eszsb.style.display == 'block'){
                 eszsb.style.display = 'none';}
              else{
                 eszsb.style.display = 'block';}
           }
        </script>
        <script>
        function optionarrow() {
              var eszsa = document.getElementById('optionsa');
              if(eszsa.style.backgroundPosition == '100% 1px'){
                 eszsa.style.backgroundPosition = '100% -41px';}
              else{
                 eszsa.style.backgroundPosition = '100% 1px';}
           }
        </script>
        <script>
        function focustxt(){document.getElementById('texturl').focus();}
        </script>


</head>
<body class="<?php echo $context; ?> <?php echo $bodyclass; ?>" onload="setTimeout('focustxt()',100)">
<div id="wrap">
	<?php
}

/**
 * Display HTML footer (including closing body & html tags)
 *
 */
function yourls_html_footer() {
	global $ydb;
	
	$num_queries = sprintf( yourls_n( '1 query', '%s queries', $ydb->num_queries ), $ydb->num_queries );
	?>
	</div> <?php // wrap ?>
	<div id="footer"><div id="finside">
<div style="float:left;">
<a href="https://www.microhealthllc.com/about/terms-of-use" title="Terms of Use">Terms of Use</a>
</div>
<div style="max-width: 300px;text-align: center;display: inline;">
		<?php
		$footer  = yourls_s( 'Powered by %s', '<a href="http://yourls.org/" title="YOURLS">YOURLS</a> v ' . YOURLS_VERSION );
		echo yourls_apply_filters( 'html_footer_text', $footer );
		?>
</div>
<div style="float:right;">
<a href="https://www.microhealthllc.com" title="MicroHealth">MicroHealth</a>
</div>
	</p></div>
	<?php if( defined( 'YOURLS_DEBUG' ) && YOURLS_DEBUG == true ) {
		echo '<p>'. $ydb->all_queries .'<p>';
	} ?>
	<?php yourls_do_action( 'html_footer', $ydb->context ); ?>
	</body>
	</html>
	<?php
}

/**
 * Display "Add new URL" box
 *
 * @param string $url URL to prefill the input with
 * @param string $keyword Keyword to prefill the input with
 */
function yourls_html_addnew( $url = '', $keyword = '' ) {
	$url = $url ? $url : 'http://';
	?>
	<div id="new_url">
		<div>
			<form id="new_url_form" action="" method="get">
				<div><strong><?php yourls_e( 'Enter the URL' ); ?></strong>:<input type="text" id="add-url" name="url" value="<?php echo $url; ?>" class="text" size="80" />
				<?php yourls_e( 'Optional '); ?>: <strong><?php yourls_e('Custom short URL'); ?></strong>:<input type="text" id="add-keyword" name="keyword" value="<?php echo $keyword; ?>" class="text" size="8" />
				<?php yourls_nonce_field( 'add_url', 'nonce-add' ); ?>
				<input type="button" id="add-button" name="add-button" value="<?php yourls_e( 'Shorten The URL' ); ?>" class="button" onclick="add_link();" /></div>
			</form>
			<div id="feedback" style="display:none"></div>
		</div>
		<?php yourls_do_action( 'html_addnew' ); ?>
	</div>
	<?php 
}

/**
 * Display main table's footer
 *
 * The $param array is defined in /admin/index.php, check the yourls_html_tfooter() call
 *
 * @param array $params Array of all required parameters
 * @return string Result
 */
function yourls_html_tfooter( $params = array() ) {
	extract( $params ); // extract $search_text, $page, $search_in ...
	?>
	<tfoot>
		<tr>
			<th colspan="6">
			<div id="filter_form">
				<form action="" method="get">
					<div id="filter_options">
						<?php
						
						// First search control: text to search
						$_input = '<input type="text" name="search" class="text" size="12" value="' . yourls_esc_attr( $search_text ) . '" />';
						$_options = array(
							'keyword' => yourls__( 'Short URL' ),
							'url'     => yourls__( 'URL' ),
							'title'   => yourls__( 'Title' ),
							'ip'      => yourls__( 'IP' ),
						);							
						$_select = yourls_html_select( 'search_in', $_options, $search_in );
						/* //translators: "Search for <input field with text to search> in <select dropdown with URL, title...>" */
						yourls_se( 'Search for %1$s in %2$s', $_input , $_select );
						echo "&ndash;\n";
						
						// Second search control: order by
						$_options = array(
							'keyword'      => yourls__( 'Short URL' ),
							'url'          => yourls__( 'URL' ),
							'timestamp'    => yourls__( 'Date' ),
							'ip'           => yourls__( 'IP' ),
							'clicks'       => yourls__( 'Clicks' ),
						);
						$_select = yourls_html_select( 'sort_by', $_options, $sort_by );
						$sort_order = isset( $sort_order ) ? $sort_order : 'desc' ;
						$_options = array(
							'asc'  => yourls__( 'Ascending' ),
							'desc' => yourls__( 'Descending' ),
						);
						$_select2 = yourls_html_select( 'sort_order', $_options, $sort_order );
						/* //translators: "Order by <criteria dropdown (date, clicks...)> in <order dropdown (Descending or Ascending)>" */
						yourls_se( 'Order by %1$s %2$s', $_select , $_select2 );
						echo "&ndash;\n";
						
						// Third search control: Show XX rows
						/* //translators: "Show <text field> rows" */
						yourls_se( 'Show %s rows',  '<input type="text" name="perpage" class="text" size="2" value="' . $perpage . '" />' );
						echo "<br/>\n";

						// Fourth search control: Show links with more than XX clicks
						$_options = array(
							'more' => yourls__( 'more' ),
							'less' => yourls__( 'less' ),
						);
						$_select = yourls_html_select( 'click_filter', $_options, $click_filter );
						$_input  = '<input type="text" name="click_limit" class="text" size="4" value="' . $click_limit . '" /> ';
						/* //translators: "Show links with <more/less> than <text field> clicks" */
						yourls_se( 'Show links with %1$s than %2$s clicks', $_select, $_input );
						echo "<br/>\n";

						// Fifth search control: Show links created before/after/between ...
						$_options = array(
							'before'  => yourls__('before'),
							'after'   => yourls__('after'),
							'between' => yourls__('between'),
						);
						$_select = yourls_html_select( 'date_filter', $_options, $date_filter );
						$_input  = '<input type="text" name="date_first" id="date_first" class="text" size="12" value="' . $date_first . '" />';
						$_and    = '<span id="date_and"' . ( $date_filter === 'between' ? ' style="display:inline"' : '' ) . '> &amp; </span>';
						$_input2 = '<input type="text" name="date_second" id="date_second" class="text" size="12" value="' . $date_second . '"' . ( $date_filter === 'between' ? ' style="display:inline"' : '' ) . '/>';
						/* //translators: "Show links created <before/after/between> <date input> <"and" if applicable> <date input if applicable>" */
						yourls_se( 'Show links created %1$s %2$s %3$s %4$s', $_select, $_input, $_and, $_input2 );
						?>

						<div id="filter_buttons">
							<input type="submit" id="submit-sort" value="<?php yourls_e('Search'); ?>" class="button primary" />
							&nbsp;
							<input type="button" id="submit-clear-filter" value="<?php yourls_e('Clear'); ?>" class="button" onclick="window.parent.location.href = 'index.php'" />
						</div>
				
					</div>
				</form>
			</div>
			
			<?php
			// Remove empty keys from the $params array so it doesn't clutter the pagination links
			$params = array_filter( $params, 'yourls_return_if_not_empty_string' ); // remove empty keys

			if( isset( $search_text ) ) {
				$params['search'] = $search_text;
				unset( $params['search_text'] );
			}
			?>
			
			<div id="pagination">
				<span class="navigation">
				<?php if( $total_pages > 1 ) { ?>
					<span class="nav_total"><?php echo sprintf( yourls_n( '1 page', '%s pages', $total_pages ), $total_pages ); ?></span>
					<?php
					$base_page = yourls_admin_url( 'index.php' );
					// Pagination offsets: min( max ( zomg! ) );
					$p_start = max(  min( $total_pages - 4, $page - 2 ), 1 );
					$p_end = min( max( 5, $page + 2 ), $total_pages );
					if( $p_start >= 2 ) {
						$link = yourls_add_query_arg( array_merge( $params, array( 'page' => 1 ) ), $base_page );
						echo '<span class="nav_link nav_first"><a href="' . $link . '" title="' . yourls_esc_attr__('Go to First Page') . '">' . yourls__( '&laquo; First' ) . '</a></span>';
						echo '<span class="nav_link nav_prev"></span>';
					}
					for( $i = $p_start ; $i <= $p_end; $i++ ) {
						if( $i == $page ) {
							echo "<span class='nav_link nav_current'>$i</span>";
						} else {
							$link = yourls_add_query_arg( array_merge( $params, array( 'page' => $i ) ), $base_page );
							echo '<span class="nav_link nav_goto"><a href="' . $link . '" title="' . sprintf( yourls_esc_attr( 'Page %s' ), $i ) .'">'.$i.'</a></span>';
						}
					}
					if( ( $p_end ) < $total_pages ) {
						$link = yourls_add_query_arg( array_merge( $params, array( 'page' => $total_pages ) ), $base_page );
						echo '<span class="nav_link nav_next"></span>';
						echo '<span class="nav_link nav_last"><a href="' . $link . '" title="' . yourls_esc_attr__('Go to First Page') . '">' . yourls__( 'Last &raquo;' ) . '</a></span>';
					}
					?>
				<?php } ?>
				</span>
			</div>
			</th>
		</tr>
		<?php yourls_do_action( 'html_tfooter' ); ?>
	</tfoot>
	<?php
}

/**
 * Return a select box
 *
 * @since 1.6
 *
 * @param string $name HTML 'name' (also use as the HTML 'id')
 * @param array $options array of 'value' => 'Text displayed'
 * @param string $selected optional 'value' from the $options array that will be highlighted
 * @param boolean $display false (default) to return, true to echo
 * @return HTML content of the select element
 */
function yourls_html_select( $name, $options, $selected = '', $display = false ) {
	$html = "<select name='$name' id='$name' size='1'>\n";
	foreach( $options as $value => $text ) {
		$html .= "<option value='$value' ";
		$html .= $selected == $value ? ' selected="selected"' : '';
		$html .= ">$text</option>\n";
	}
	$html .= "</select>\n";
	$html  = yourls_apply_filters( 'html_select', $html, $name, $options, $selected, $display );
	if( $display )
		echo $html;
	return $html;
}

/**
 * Display the Quick Share box
 *
 */
function yourls_share_box( $longurl, $shorturl, $title = '', $text='', $shortlink_title = '', $share_title = '', $hidden = false ) {
	if ( $shortlink_title == '' )
		$shortlink_title = '<div id="hctxt" style="margin:5px;">' . yourls__( 'Your shortened URL is:' ) . '</div>';
	if ( $share_title == '' )
		$share_title = '<div id="hctxt" style="margin:5px;">' . yourls__( 'Quick Share' ) . '</div>';
	
	// Allow plugins to short-circuit the whole function
	$pre = yourls_apply_filter( 'shunt_share_box', false );
	if ( false !== $pre )
		return $pre;
		
	$text   = ( $text ? '"'.$text.'" ' : '' );
	$title  = ( $title ? "$title " : '' );
	$share  = yourls_esc_textarea( $title.$text.$shorturl );
	$count  = 140 - strlen( $share );
	$hidden = ( $hidden ? 'style="display:none;"' : '' );
	
	// Allow plugins to filter all data
	$data = compact( 'longurl', 'shorturl', 'title', 'text', 'shortlink_title', 'share_title', 'share', 'count', 'hidden' );
	$data = yourls_apply_filter( 'share_box_data', $data );
	extract( $data );
	
	$_share = rawurlencode( $share );
	$_url   = rawurlencode( $shorturl );
	?>
	
	<div id="shareboxes" <?php echo $hidden; ?>>

		<?php yourls_do_action( 'shareboxes_before', $longurl, $shorturl, $title, $text ); ?>

		<div id="copybox" class="share">
			<div style="text-align:center;">
<div style="max-width: 540px;display: inline-block;text-align: left;"><?php echo $shortlink_title; ?><input id="copylinktxt" class="text" size="32" value="<?php echo yourls_esc_url( $shorturl ); ?>" />
<div style="margin:5px;">
<?php yourls_e( 'Your shortened URL goes to' ); ?>: <a id="origlink" target="_blank" href="<?php echo yourls_esc_url( $longurl ); ?>"><?php echo yourls_esc_url( $longurl ); ?></a>
			<?php if( yourls_do_log_redirect() ) { ?>
			<input type="hidden" id="titlelink" value="<?php echo yourls_esc_attr( $title ); ?>" />
			<?php } ?>
</div>
</div>


<div id="copylink" class="sbutton" style="max-width: 142px;display: inline-block;vertical-align: top;margin-top: 26px;">Copy</div></div>
			
			
		</div>
		<?php yourls_do_action( 'shareboxes_middle', $longurl, $shorturl, $title, $text ); ?>
		<?php yourls_do_action( 'shareboxes_after', $longurl, $shorturl, $title, $text ); ?>
	

<div style="padding-left: 45px;margin-top: 35px;">

<?php

require_once( YOURLS_ABSPATH . '/includes/ayah.php' );
$ayah = new AYAH();

if (array_key_exists('ssubmit', $_POST))
{
        // Use the AYAH object to see if the user passed or failed the game.
        $score = $ayah->scoreResult();

        if ($score)
        {
        }
        else
        {
        }
}

		$site = YOURLS_SITE;
		$humver = $ayah->getPublisherHTML();
		// Display the form
		echo <<<HTML
		<form method="post" action="" target="_parent" >
		<div style="text-align:center;">
                <div style="max-width: 540px;display: inline-block;text-align: right;"><div style="margin:5px;text-align:left;">Shorten another URL:</div><input width="500" placeholder="Paste or enter a hyperlink here" id="texturl" type="text" class="text" name="url"  />
                    <div id="optionsc">
                      <div id="optionsa" onclick="optionshow()">Options</div>
                      <div id="optionsb"><label>Custom URL: $site/<input type="text" class="text" name="keyword" /></label></div>
                    </div></div>
                <div style="max-width: 142px;display: inline-block;vertical-align: top;margin-top: 24px;"> 

             $humver
<input type="submit" class="button primary" value="Shorten" name="ssubmit" id="sbutton" /></div></div>
		</form>	
HTML;



?>
</div>



	</div>
	
	<?php
}

/**
 * Die die die
 *
 */
function yourls_die( $message = '', $title = '', $header_code = 200 ) {
	yourls_status_header( $header_code );
	
	if( !yourls_did_action( 'html_head' ) ) {
		yourls_html_head();
		yourls_html_logo();
	}
	echo yourls_apply_filter( 'die_title', "<h2 style=\"text-align:center\">$title</h2>" );
	echo yourls_apply_filter( 'die_message', "<p style=\"text-align:center\">$message</p>" );
	yourls_do_action( 'yourls_die' );
	if( !yourls_did_action( 'html_head' ) ) {
		yourls_html_footer();
	}
	die();
}

/**
 * Return an "Edit" row for the main table
 *
 * @param string $keyword Keyword to edit
 * @return string HTML of the edit row
 */
function yourls_table_edit_row( $keyword ) {
	global $ydb;
	
	$table = YOURLS_DB_TABLE_URL;
	$keyword = yourls_sanitize_string( $keyword );
	$id = yourls_string2htmlid( $keyword ); // used as HTML #id
	$url = yourls_get_keyword_longurl( $keyword );
	
	$title = htmlspecialchars( yourls_get_keyword_title( $keyword ) );
	$safe_url = yourls_esc_attr( $url );
	$safe_title = yourls_esc_attr( $title );
	$www = yourls_link();
	
	$save_link = yourls_nonce_url( 'save-link_'.$id,
		yourls_add_query_arg( array( 'id' => $id, 'action' => 'edit_save', 'keyword' => $keyword ), yourls_admin_url( 'admin-ajax.php' ) ) 
	);
	
	$nonce = yourls_create_nonce( 'edit-save_'.$id );
	
	if( $url ) {
		$return = <<<RETURN
<tr id="edit-$id" class="edit-row"><td colspan="5" class="edit-row"><strong>%s</strong>:<input type="text" id="edit-url-$id" name="edit-url-$id" value="$safe_url" class="text" size="70" /><br/><strong>%s</strong>: $www<input type="text" id="edit-keyword-$id" name="edit-keyword-$id" value="$keyword" class="text" size="10" /><br/><strong>%s</strong>: <input type="text" id="edit-title-$id" name="edit-title-$id" value="$safe_title" class="text" size="60" /></td><td colspan="1"><input type="button" id="edit-submit-$id" name="edit-submit-$id" value="%s" title="%s" class="button" onclick="edit_link_save('$id');" />&nbsp;<input type="button" id="edit-close-$id" name="edit-close-$id" value="%s" title="%s" class="button" onclick="edit_link_hide('$id');" /><input type="hidden" id="old_keyword_$id" value="$keyword"/><input type="hidden" id="nonce_$id" value="$nonce"/></td></tr>
RETURN;
		$return = sprintf( urldecode( $return ), yourls__( 'Long URL' ), yourls__( 'Short URL' ), yourls__( 'Title' ), yourls__( 'Save' ), yourls__( 'Save new values' ), yourls__( 'Cancel' ), yourls__( 'Cancel editing' ) );
	} else {
		$return = '<tr class="edit-row notfound">><td colspan="6" class="edit-row notfound">' . yourls__( 'Error, URL not found' ) . '</td></tr>';
	}
	
	$return = yourls_apply_filter( 'table_edit_row', $return, $keyword, $url, $title );

	return $return;
}

/**
 * Return an "Add" row for the main table
 *
 * @return string HTML of the edit row
 */
function yourls_table_add_row( $keyword, $url, $title = '', $ip, $clicks, $timestamp ) {
	$keyword  = yourls_sanitize_string( $keyword );
	$id       = yourls_string2htmlid( $keyword ); // used as HTML #id
	$shorturl = yourls_link( $keyword );

	$statlink = yourls_statlink( $keyword );
		
	$delete_link = yourls_nonce_url( 'delete-link_'.$id,
		yourls_add_query_arg( array( 'id' => $id, 'action' => 'delete', 'keyword' => $keyword ), yourls_admin_url( 'admin-ajax.php' ) ) 
	);
	
	$edit_link = yourls_nonce_url( 'edit-link_'.$id,
		yourls_add_query_arg( array( 'id' => $id, 'action' => 'edit', 'keyword' => $keyword ), yourls_admin_url( 'admin-ajax.php' ) ) 
	);
	
	// Action link buttons: the array
	$actions = array(
		'stats' => array(
			'href'    => $statlink,
			'id'      => "statlink-$id",
			'title'   => yourls_esc_attr__( 'Stats' ),
			'anchor'  => yourls__( 'Stats' ),
		),
		'share' => array(
			'href'    => '',
			'id'      => "share-button-$id",
			'title'   => yourls_esc_attr__( 'Share' ),
			'anchor'  => yourls__( 'Share' ),
			'onclick' => "toggle_share('$id');return false;",
		),
		'edit' => array(
			'href'    => $edit_link,
			'id'      => "edit-button-$id",
			'title'   => yourls_esc_attr__( 'Edit' ),
			'anchor'  => yourls__( 'Edit' ),
			'onclick' => "edit_link_display('$id');return false;",
		),
		'delete' => array(
			'href'    => $delete_link,
			'id'      => "delete-button-$id",
			'title'   => yourls_esc_attr__( 'Delete' ),
			'anchor'  => yourls__( 'Delete' ),
			'onclick' => "remove_link('$id');return false;",
		)
	);
	$actions = yourls_apply_filter( 'table_add_row_action_array', $actions );
	
	// Action link buttons: the HTML
	$action_links = '';
	foreach( $actions as $key => $action ) {
		$onclick = isset( $action['onclick'] ) ? 'onclick="' . $action['onclick'] . '"' : '' ;
		$action_links .= sprintf( '<a href="%s" id="%s" title="%s" class="%s" %s>%s</a>',
			$action['href'], $action['id'], $action['title'], 'button button_'.$key, $onclick, $action['anchor']
		);
	}
	$action_links = yourls_apply_filter( 'action_links', $action_links, $keyword, $url, $ip, $clicks, $timestamp );

	if( ! $title )
		$title = $url;

	$protocol_warning = '';
	if( ! in_array( yourls_get_protocol( $url ) , array( 'http://', 'https://' ) ) )
		$protocol_warning = yourls_apply_filters( 'add_row_protocol_warning', '<span class="warning" title="' . yourls__( 'Not a common link' ) . '">&#9733;</span>' );

	// Row cells: the array
	$cells = array(
		'keyword' => array(
			'template'      => '<a href="%shorturl%">%keyword_html%</a>',
			'shorturl'      => yourls_esc_url( $shorturl ),
			'keyword_html'  => yourls_esc_html( $keyword ),
		),
		'url' => array(
			'template'      => '<a href="%long_url%" title="%title_attr%">%title_html%</a><br/><small>%warning%<a href="%long_url%">%long_url_html%</a></small>',
			'long_url'      => yourls_esc_url( $url ),
			'title_attr'    => yourls_esc_attr( $title ),
			'title_html'    => yourls_esc_html( yourls_trim_long_string( $title ) ),
			'long_url_html' => yourls_esc_html( yourls_trim_long_string( $url ) ),
			'warning'       => $protocol_warning,
		),
		'timestamp' => array(
			'template' => '%date%',
			'date'     => date( 'M d, Y H:i', $timestamp +( YOURLS_HOURS_OFFSET * 3600 ) ),
		),
		'ip' => array(
			'template' => '%ip%',
			'ip'       => $ip,
		),
		'clicks' => array(
			'template' => '%clicks%',
			'clicks'   => yourls_number_format_i18n( $clicks, 0, '', '' ),
		),
		'actions' => array(
			'template' => '%actions% <input type="hidden" id="keyword_%id%" value="%keyword%"/>',
			'actions'  => $action_links,
			'id'       => $id,
			'keyword'  => $keyword,
		),
	);
	$cells = yourls_apply_filter( 'table_add_row_cell_array', $cells, $keyword, $url, $title, $ip, $clicks, $timestamp );
	
	// Row cells: the HTML. Replace every %stuff% in 'template' with 'stuff' value.
	$row = "<tr id=\"id-$id\">";
	foreach( $cells as $cell_id => $elements ) {
		$row .= sprintf( '<td class="%s" id="%s">', $cell_id, $cell_id . '-' . $id );
		$row .= preg_replace( '/%([^%]+)?%/e', '$elements["$1"]', $elements['template'] );
		$row .= '</td>';
	}
	$row .= "</tr>";
	$row  = yourls_apply_filter( 'table_add_row', $row, $keyword, $url, $title, $ip, $clicks, $timestamp );
	
	return $row;
}

/**
 * Echo the main table head
 *
 */
function yourls_table_head() {
	$start = '<table id="main_table" class="tblSorter" cellpadding="0" cellspacing="1"><thead><tr>'."\n";
	echo yourls_apply_filter( 'table_head_start', $start );
	
	$cells = yourls_apply_filter( 'table_head_cells', array(
		'shorturl' => yourls__( 'Short URL' ),
		'longurl'  => yourls__( 'Original URL' ),
		'date'     => yourls__( 'Date' ),
		'ip'       => yourls__( 'IP' ),
		'clicks'   => yourls__( 'Clicks' ),
		'actions'  => yourls__( 'Actions' )
	) );
	foreach( $cells as $k => $v ) {
		echo "<th id='main_table_head_$k'>$v</th>\n";
	}
	
	$end = "</tr></thead>\n";
	echo yourls_apply_filter( 'table_head_end', $end );
}

/**
 * Echo the tbody start tag
 *
 */
function yourls_table_tbody_start() {
	echo yourls_apply_filter( 'table_tbody_start', '<tbody>' );
}

/**
 * Echo the tbody end tag
 *
 */
function yourls_table_tbody_end() {
	echo yourls_apply_filter( 'table_tbody_end', '</tbody>' );
}

/**
 * Echo the table start tag
 *
 */
function yourls_table_end() {
	echo yourls_apply_filter( 'table_end', '</table>' );
}

/**
 * Echo HTML tag for a link
 *
 */
function yourls_html_link( $href, $title = '', $element = '' ) {
	if( !$title )
		$title = $href;
	if( $element )
		$element = sprintf( 'id="%s"', yourls_esc_attr( $element ) );
	$link = sprintf( '<a href="%s" %s>%s</a>', yourls_esc_url( $href ), $element, yourls_esc_html( $title ) );
	echo yourls_apply_filter( 'html_link', $link );
}

/**
 * Display the login screen. Nothing past this point.
 *
 */
function yourls_login_screen( $error_msg = '' ) {
	yourls_html_head( 'login' );
	
	$action = ( isset( $_GET['action'] ) && $_GET['action'] == 'logout' ? '?' : '' );

	yourls_html_logo();
	?>
<?php

require_once( YOURLS_ABSPATH . '/includes/ayah.php' );
$ayah = new AYAH();

if (array_key_exists('lsubmit', $_POST))
{
        // Use the AYAH object to see if the user passed or failed the game.
        $score = $ayah->scoreResult();

        if ($score)
        {
        }
        else
        {
        }
}
?>
	<div id="login">
		<form method="post" action="<?php echo $action; ?>"> <?php // reset any QUERY parameters ?>
			<?php
				if( !empty( $error_msg ) ) {
					echo '<p class="error">'.$error_msg.'</p>';
				}
			?>
			<p>
				<label for="username"><?php yourls_e( 'Username' ); ?></label><br />
				<input type="text" id="username" name="username" size="30" class="text" />
			</p>
			<p>
				<label for="password"><?php yourls_e( 'Password' ); ?></label><br />
				<input type="password" id="password" name="password" size="30" class="text" />
			</p>
			<p style="text-align: right;">
        
<?php echo $ayah->getPublisherHTML(); ?>
				<input type="submit" id="submit" name="lsubmit" value="<?php yourls_e( 'Login' ); ?>" class="button" />
			</p>
		</form>
		<script type="text/javascript">$('#username').focus();</script>
	</div>
	<?php
	yourls_html_footer();
	die();
}

/**
 * Display the admin menu
 *
 */
function yourls_html_menu() {

	// Build menu links
	if( defined( 'YOURLS_USER' ) ) {
		$logout_link = yourls_apply_filter( 'logout_link', sprintf( yourls__('Hello <strong>%s</strong>'), YOURLS_USER ) . ' </strong> (<a href="?action=logout" title="' . yourls_esc_attr__( 'Logout' ) . '">' . yourls__( 'Logout' ) . '</a>)' );
	} else {
		$logout_link = yourls_apply_filter( 'logout_link', '' );
	}
	$help_link   = yourls_apply_filter( 'help_link',   '<a href="' . yourls_site_url( false ) .'/readme.html">' . yourls__( 'Help' ) . '</a>' );
	
	$admin_links    = array();
	$admin_sublinks = array();
	
	$admin_links['admin'] = array(
		'url'    => yourls_admin_url( 'index.php' ),
		'title'  => yourls__( 'Go to the admin interface' ),
		'anchor' => yourls__( 'Admin interface' )
	);
	
	if( yourls_is_admin() ) {
		$admin_links['tools'] = array(
			'url'    => yourls_admin_url( 'tools.php' ),
			'anchor' => yourls__( 'Tools' )
		);
		$admin_links['plugins'] = array(
			'url'    => yourls_admin_url( 'plugins.php' ),
			'anchor' => yourls__( 'Manage Plugins' )
		);
		$admin_sublinks['plugins'] = yourls_list_plugin_admin_pages();
	}
	
	$admin_links    = yourls_apply_filter( 'admin_links',    $admin_links );
	$admin_sublinks = yourls_apply_filter( 'admin_sublinks', $admin_sublinks );
	
	// Now output menu
	echo '<ul id="admin_menu">'."\n";
	if ( yourls_is_private() && !empty( $logout_link ) )
		echo '<li id="admin_menu_logout_link">' . $logout_link .'</li>';

	foreach( (array)$admin_links as $link => $ar ) {
		if( isset( $ar['url'] ) ) {
			$anchor = isset( $ar['anchor'] ) ? $ar['anchor'] : $link;
			$title  = isset( $ar['title'] ) ? 'title="' . $ar['title'] . '"' : '';
			printf( '<li id="admin_menu_%s_link" class="admin_menu_toplevel"><a href="%s" %s>%s</a>', $link, $ar['url'], $title, $anchor );
		}
		// Output submenu if any. TODO: clean up, too many code duplicated here
		if( isset( $admin_sublinks[$link] ) ) {
			echo "<ul>\n";
			foreach( $admin_sublinks[$link] as $link => $ar ) {
				if( isset( $ar['url'] ) ) {
					$anchor = isset( $ar['anchor'] ) ? $ar['anchor'] : $link;
					$title  = isset( $ar['title'] ) ? 'title="' . $ar['title'] . '"' : '';
					printf( '<li id="admin_menu_%s_link" class="admin_menu_sublevel admin_menu_sublevel_%s"><a href="%s" %s>%s</a>', $link, $link, $ar['url'], $title, $anchor );
				}
			}
			echo "</ul>\n";
		}
	}
	
	if ( isset( $help_link ) )
		echo '<li id="admin_menu_help_link">' . $help_link .'</li>';
		
	yourls_do_action( 'admin_menu' );
	echo "</ul>\n";
	yourls_do_action( 'admin_notices' );
	yourls_do_action( 'admin_notice' ); // because I never remember if it's 'notices' or 'notice'
	/*
	To display a notice:
	$message = "<div>OMG, dude, I mean!</div>" );
	yourls_add_action( 'admin_notices', create_function( '', "echo '$message';" ) );
	*/
}

/**
 * Wrapper function to display admin notices
 *
 */
function yourls_add_notice( $message, $style = 'notice' ) {
	$message = yourls_notice_box( $message, $style );
	yourls_add_action( 'admin_notices', create_function( '', "echo '$message';" ) );
}

/**
 * Return a formatted notice
 *
 */
function yourls_notice_box( $message, $style = 'notice' ) {
	return <<<HTML
	<div class="$style">
	<p>$message</p>
	</div>
HTML;
}

/**
 * Display a page
 *
 */
function yourls_page( $page ) {
	$include = YOURLS_ABSPATH . "/pages/$page.php";
	if( !file_exists($include) ) {
		yourls_die( "Page '$page' not found", 'Not found', 404 );
	}
	yourls_do_action( 'pre_page', $page );
	include($include);
	yourls_do_action( 'post_page', $page );
	die();	
}

/**
 * Display the language attributes for the HTML tag.
 *
 * Builds up a set of html attributes containing the text direction and language
 * information for the page. Stolen from WP.
 *
 * @since 1.6
 */
function yourls_html_language_attributes() {
	$attributes = array();
	$output = '';
	
	$attributes[] = ( yourls_is_rtl() ? 'dir="rtl"' : 'dir="ltr"' );
	
	$doctype = yourls_apply_filters( 'html_language_attributes_doctype', 'html' );
	// Experimental: get HTML lang from locale. Should work. Convert fr_FR -> fr-FR
	if ( $lang = str_replace( '_', '-', yourls_get_locale() ) ) {
		if( $doctype == 'xhtml' ) {
			$attributes[] = "xml:lang=\"$lang\"";
		} else {
			$attributes[] = "lang=\"$lang\"";
		}
	}

	$output = implode( ' ', $attributes );
	$output = yourls_apply_filters( 'html_language_attributes', $output );
	echo $output;
}

/**
 * Output translated strings used by the Javascript calendar
 *
 * @since 1.6
 */
function yourls_l10n_calendar_strings() {
	echo "\n<script>\n";
	echo "var l10n_cal_month = " . json_encode( array_values( yourls_l10n_months() ) ) . ";\n";
	echo "var l10n_cal_days = " . json_encode( array_values( yourls_l10n_weekday_initial() ) ) . ";\n";
	echo "var l10n_cal_today = \"" . yourls_esc_js( yourls__( 'Today' ) ) . "\";\n";
	echo "var l10n_cal_close = \"" . yourls_esc_js( yourls__( 'Close' ) ) . "\";\n";
	echo "</script>\n";
	
	// Dummy returns, to initialize l10n strings used in the calendar
	yourls__( 'Today' );
	yourls__( 'Close' );
}