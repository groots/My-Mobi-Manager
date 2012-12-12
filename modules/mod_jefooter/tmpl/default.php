<?php // no direct access
defined('_JEXEC') or die('Restricted access');

$footer = '';

// Copyright text
switch($params->get('copyright_text')){
	case "1" : // DEFAULT_COPYRIGHT_TEXT
		$copyright_text = 'Copyright';
		break;
	case "2" : // CUSTOM_COPYRIGHT_TEXT
		$copyright_text = $params->get('copyright_custom_text');
		break;
	default : // HIDE
		$copyright_text = '';
		break;
}

// Copyright symbol
switch($params->get('copyright_text')){
	case "1" : // DEFAULT_COPYRIGHT_SYMBOL
		$copyright_symbol = '&copy;';
		break;
	case "2" : // CUSTOM_COPYRIGHT_SYMBOL
		$copyright_symbol = $params->get('copyright_custom_symbol');
		break;
	default : // HIDE
		$copyright_symbol = '';
		break;
}

// Copyright order
if($params->get('copyright_order') == '1'){ // COPYRIGHT_TEXT_FIRST
	$footer .= $copyright_text;
	if (($footer != '') && ($copyright_symbol != '')) $footer .= '&nbsp;';
	$footer .= $copyright_symbol;
}
else{ // COPYRIGHT_SYMBOL_FIRST
	$footer .= $copyright_symbol;
	if (($footer != '') && ($copyright_text != '')) $footer .= '&nbsp;';
	$footer .= $copyright_text;
}

// Copyright year
$current_year = date('Y');
$copyright_start_year = $params->get('copyright_start_year',$current_year);
switch($params->get('copyright_year')){
	case "1" : // START_YEAR_AND_CURRENT_YEAR
		$copyright_year = $copyright_start_year . (($copyright_start_year != $current_year) ? '-' . $current_year : '');
		break;
	case "2" : // START_YEAR_ONLY
		$copyright_year = $copyright_start_year;
		break;
	case "3" : // CURRENT_YEAR_ONLY
		$copyright_year = $current_year;
		break;
	default : // HIDE
		$copyright_year = '';
		break;
}
if (($footer != '') && ($copyright_year != '')) $footer .= '&nbsp;';
$footer .= $copyright_year;

// Copyright author
switch($params->get('copyright_author')){
	case "1" : // COPYRIGHT_AUTHOR as SITE_NAME
		$app = JFactory::getApplication();
		$copyright_author = $app->getCfg('sitename');
		break;
	case "2" : // COPYRIGHT_AUTHOR as CUSTOM_AUTHOR_NAME
		$copyright_author = $params->get('copyright_custom_author');
		break;
	default : // HIDE
		$copyright_author = '';
		break;
}
$copyright_author_url = $params->get('copyright_author_url');
$copyright_author_url_target = $params->get('copyright_author_url_target');
if(($copyright_author_url != '') && ($params->get('copyright_author_link') == '1')){
	$copyright_author = '<a href="'.$copyright_author_url.'" target="'.$copyright_author_url_target.'">'.$copyright_author.'</a>';
}
if (($footer != '') && ($copyright_author != '')) $footer .= '&nbsp;';
$footer .= $copyright_author;

// Additional info
$additional = '';
$additional_label = $params->get('additional_1_label');
$additional_text = $params->get('additional_1_text');
$additional_url = $params->get('additional_1_url');
$additional_url_target = $params->get('additional_1_url_target');
switch($params->get('additional_1')){
	case "1" : // SHOW
		$additional .= $additional_label;
		$additional .= $additional_text;
		break;
	case "2" : // SHOW_WITH_LINK
		$additional .= $additional_label;
		if($additional_url != ''){
			$additional .= '<a href="'.$additional_url.'" target="'.$additional_url_target.'">'.$additional_text.'</a>';
		}
		else{
			$additional .= $additional_text;
		}
		break;
	default : // HIDE
		$additional .= '';
		break;
}

$additional_label = $params->get('additional_2_label');
$additional_text = $params->get('additional_2_text');
$additional_url = $params->get('additional_2_url');
$additional_url_target = $params->get('additional_2_url_target');
switch($params->get('additional_2')){
	case "1" : // SHOW
		$additional .= $additional_label;
		$additional .= $additional_text;
		break;
	case "2" : // SHOW_WITH_LINK
		$additional .= $additional_label;
		if($additional_url != ''){
			$additional .= '<a href="'.$additional_url.'" target="'.$additional_url_target.'">'.$additional_text.'</a>';
		}
		else{
			$additional .= $additional_text;
		}
		break;
	default : // HIDE
		$additional .= '';
		break;
}

$additional_label = $params->get('additional_3_label');
$additional_text = $params->get('additional_3_text');
$additional_url = $params->get('additional_3_url');
$additional_url_target = $params->get('additional_3_url_target');
switch($params->get('additional_3')){
	case "1" : // SHOW
		$additional .= $additional_label;
		$additional .= $additional_text;
		break;
	case "2" : // SHOW_WITH_LINK
		$additional .= $additional_label;
		if($additional_url != ''){
			$additional .= '<a href="'.$additional_url.'" target="'.$additional_url_target.'">'.$additional_text.'</a>';
		}
		else{
			$additional .= $additional_text;
		}
		break;
	default : // HIDE
		$additional .= '';
		break;
}

$additional_label = $params->get('additional_4_label');
$additional_text = $params->get('additional_4_text');
$additional_url = $params->get('additional_4_url');
$additional_url_target = $params->get('additional_4_url_target');
switch($params->get('additional_4')){
	case "1" : // SHOW
		$additional .= $additional_label;
		$additional .= $additional_text;
		break;
	case "2" : // SHOW_WITH_LINK
		$additional .= $additional_label;
		if($additional_url != ''){
			$additional .= '<a href="'.$additional_url.'" target="'.$additional_url_target.'">'.$additional_text.'</a>';
		}
		else{
			$additional .= $additional_text;
		}
		break;
	default : // HIDE
		$additional .= '';
		break;
}

$additional_label = $params->get('additional_5_label');
$additional_text = $params->get('additional_5_text');
$additional_url = $params->get('additional_5_url');
$additional_url_target = $params->get('additional_5_url_target');
switch($params->get('additional_5')){
	case "1" : // SHOW
		$additional .= $additional_label;
		$additional .= $additional_text;
		break;
	case "2" : // SHOW_WITH_LINK
		$additional .= $additional_label;
		if($additional_url != ''){
			$additional .= '<a href="'.$additional_url.'" target="'.$additional_url_target.'">'.$additional_text.'</a>';
		}
		else{
			$additional .= $additional_text;
		}
		break;
	default : // HIDE
		$additional .= '';
		break;
}
switch($params->get('seperator')){
	case "1" : // DEFAULT_SEPERATOR
		$seperator = '&nbsp;|&nbsp;';
		break;
	case "2" : // CUSTOM_SEPERATOR
		$seperator = $params->get('custom_seperator');
		break;
	default : // HIDE
		$seperator = '';
		break;
}
if (($footer != '') && ($seperator != '') && ($additional != '')) $footer .= $seperator;
$footer .= $additional;

?>

<?php if ($footer != ''){ ?>
<div id="jefooter<?php echo $params->get('moduleClassSfx');?>" style="text-align:<?php echo $params->get('align'); ?>">
<?php echo $footer; ?>
</div>
<?php } ?>
