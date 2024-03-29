<?php
/**
 * Copyright (C) 2011  freakedout (www.freakedout.de)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted Access' );

jimport('joomla.application.component.controller');

$task =	JRequest::getVar('task', '', 'post', 'string', JREQUEST_ALLOWRAW );

/**
 * joomailermailchimpintegration Controller
 *
 * @package    joomailermailchimpintegration
 * @subpackage Controllers
 */
class joomailermailchimpintegrationsControllerSync extends joomailermailchimpintegrationsController
{
	function __construct()
	{
		parent::__construct();
		// Register Extra tasks
		$this->registerTask( 'add' , 'sync' );
		$this->registerTask( 'backup' , 'sync' );
	}
	
	function sugar()
	{
		JRequest::setVar( 'view', 'sync' );
		JRequest::setVar( 'layout', 'sugar'  );
		JRequest::setVar( 'hidemainmenu', 0);
		parent::display();
	}
	function highrise()
	{
		JRequest::setVar( 'view', 'sync' );
		JRequest::setVar( 'layout', 'highrise'  );
		JRequest::setVar( 'hidemainmenu', 0);
		parent::display();
	}



	function sync()
	{

	$mainframe =& JFactory::getApplication();
	JHTMLBehavior::keepalive();

	//total number of elements to process
	$elements = JRequest::getVar('boxchecked',  0, '', 'int');
	
	if (!$elements) {
	$msg = JText::_( 'JM_NO_USERS_SELECTED' );
	} else {
	
	$db     =& JFactory::getDBO();
	$model  =& $this->getModel('sync');

	$params =& JComponentHelper::getParams( 'com_joomailermailchimpintegration' );
	$paramsPrefix = (version_compare(JVERSION,'1.6.0','ge')) ? 'params.' : '';
	$MCapi  = $params->get( $paramsPrefix.'MCapi' );
	$MC = new joomlamailerMCAPI($MCapi);
	$MCerrorHandler = new MCerrorHandler();

	$listId = JRequest::getVar('listid',  0, '', 'string');

    // gather custom fields data
	$query = "SELECT * FROM #__joomailermailchimpintegration_custom_fields WHERE listid = '".$listId."' ";
	$db->setQuery($query);
	$custom_fields = $db->loadObjectList();

	if(!isset($custom_fields[0])) $custom_fields = false;
	
	$data = JRequest::getVar('cid',  0, '', 'array');
	if (!$data) { $data = JRequest::getVar('cid[]',  0, '', 'array'); }
	
	$batch = array();
	$failed = array();

	$i=0;
	$k = 0;
	$errorcount = 0;
	$msg = $error_msg = false;
	foreach ($data as $dat){
		$i++;

		$user = $model->getUser($dat);
		$userIds[$user[0]->email] = $user[0]->id;
		$batch[$k]['EMAIL'] = $user[0]->email;
		// name
		$names = explode(' ', $user[0]->name);
		if( $names[0] && isset($names[1])) {
			$batch[$k]['FNAME'] = $names[0];
			for($i=1;$i<count($names);$i++){
				$batch[$k]['LNAME'] .= $names[$i].' ';
			}
		} else {
			$batch[$k]['FNAME'] = $user[0]->name;
		}
		
		$custom = array();

		if($custom_fields){
			foreach($custom_fields as $field){

				if($field->framework == 'CB') {
					$query = "SELECT ".$field->dbfield." FROM #__comprofiler WHERE user_id = '".$user[0]->id."' ";
				} elseif($field->framework =='JS') {
					$query = "SELECT value FROM #__community_fields_values WHERE field_id = ".$field->dbfield." AND user_id = '".$user[0]->id."' ";
				}
					$db->setQuery($query);
					$field_value = $db->loadResult();
					if($field->framework == 'CB') $field_value = str_replace('|*|', ',', $field_value);
					if($field->framework == 'JS') { 
						$field_value = (substr($field_value, strlen($field_value) - 1)==',')? $field_value = substr($field_value,0,-1):$field_value; 
						if($field_value==NULL) $field_value = '';
					}
					if($field->type=='group') {
						$batch[$k]['GROUPINGS'][] = array( 'id' => $field->grouping_id, 'groups' => $field_value);
					} else {
						$batch[$k][$field->grouping_id] = $field_value;
					}
			}
		}

		$query = 'INSERT INTO #__joomailermailchimpintegration (userid,email,listid) VALUES ("'.$user[0]->id.'", "'.$user[0]->email.'", "'.$listId.'")';
		$db->setQuery($query);
		$db->query();

		$k++;
    }

	$optin = false; //yes, send optin emails
	$up_exist = true; // yes, update currently subscribed users
	$replace_int = true; // false = add interest, don't replace

	$result = $MC->listBatchSubscribe($listId, $batch, $optin, $up_exist, $replace_int);

	$msg = $result['success_count'].' '.JText::_( 'JM_RECIPIENTS_SAVED' );
	$resubscribeLink = '';

	if ( $result['error_count'] ) {
//		var_dump($result['errors']);die;
		foreach($result['errors'] as $e){
//			$errorMsg .= '"'.$e['message'].'", ';
			$tmp = new stdClass;
			$tmp->errorCode = $e['code'];
			$tmp->errorMessage = $e['message'];
			$errorMsg .= '"'.$MCerrorHandler->getErrorMsg($tmp).' => '.$e['row']['EMAIL'].'", ';
			if($tmp->errorCode==212 && 0==1 ){  // ! 0==1 ! => don't allow admins to resubscribe unsubscribed users to prevent spam complaints
				$resubscribeLink = ' <a href="index.php?option=com_joomailermailchimpintegration&view=subscribers&listid='.$listId.'&type=u">'.
									JText::_('JM_RESUBSCRIBE_LINK').'</a>';
			}
			$failed[] = $e['row']['EMAIL'];
		}
		$errorMsg = substr($errorMsg,0,-2);
		$msg .= ' ( '.$result['error_count'].' '.JText::_('Errors').': '.$errorMsg.' )'; 
		$msg .= $resubscribeLink;
	}

	foreach($failed as $fail){
		$query = 'DELETE FROM #__joomailermailchimpintegration WHERE `listid` = "'.$listId.'" AND `email` = "'.$fail.'" LIMIT 1';
		$db->setQuery($query);
		$db->query();
	}

    } // end if (!$elements)
//}

    $link = 'index.php?option=com_joomailermailchimpintegration&view=sync';
	$mainframe->redirect($link, $msg);

	}// function sync







	function sync_all() {
	
	$mainframe =& JFactory::getApplication();
	$db =& JFactory::getDBO();
	$model  =& $this->getModel('sync');
	JHTMLBehavior::keepalive();
	
	$listId = JRequest::getVar('listid',  0, '', 'string');
	
	$query = 'SELECT userid FROM #__joomailermailchimpintegration WHERE listid = "'.$listId.'"';
	$db->setQuery($query);
	$exclude = $db->loadResultArray();
	$exclude = implode('","', $exclude);
	$exclude = '"'.$exclude.'"';
	
	$query = 'SELECT id FROM #__users WHERE id NOT IN ('.$exclude.') and block = 0';
	$db->setQuery($query);
	$data = $db->loadObjectList();
	$elements = count($data);
	
	$params =& JComponentHelper::getParams( 'com_joomailermailchimpintegration' );
	$paramsPrefix = (version_compare(JVERSION,'1.6.0','ge')) ? 'params.' : '';
	$MCapi  = $params->get( $paramsPrefix.'MCapi' );
	$MC = new MCAPI($MCapi);
	$MCerrorHandler = new MCerrorHandler();
	
	// gather custom fields data
	$db	=& JFactory::getDBO();
	$query = "SELECT * FROM #__joomailermailchimpintegration_custom_fields WHERE listid = '".$listId."' ";
	$db->setQuery($query);
	$custom_fields = $db->loadObjectList();
	if(!isset($custom_fields[0])) $custom_fields = false;
	
	$m=0;
	$successCount = $errorcount = $msgErrorsCount = 0;
	$msg = $msgErrors = false;
	
	$step = 500;
//	foreach ($data as $dat){
	for ($x=0;$x<count($data);$x+=$step){
		$k=0;
		$batch = array();
		for ($y=$x;$y<($x+$step);$y++){
			
			$dat = $data[$y];
			if($dat){
				$user = $model->getUser($dat->id);
				$batch[$k]['EMAIL'] = $user[0]->email;
				// name
				$names = explode(' ', $user[0]->name);
				if( $names[0] && $names[1]) {
					$batch[$k]['FNAME'] = $names[0];
					for($i=1;$i<count($names);$i++){
						$batch[$k]['LNAME'] .= $names[$i].' ';
					}
				} else {
					$batch[$k]['FNAME'] = $user[0]->name;
				}
				
				$custom = array();
			
				if($custom_fields){
					foreach($custom_fields as $field){
						if($field->framework == 'CB') {
							$query = "SELECT ".$field->dbfield." FROM #__comprofiler WHERE user_id = '".$user[0]->id."' ";
						} else {
							$query = "SELECT value FROM #__community_fields_values WHERE field_id = ".$field->dbfield." AND user_id = '".$user[0]->id."' ";
						}
							$db->setQuery($query);
							$field_value = $db->loadResult();
							if($field->framework == 'CB') $field_value = str_replace('|*|', ',', $field_value);
							if($field->framework == 'JS') { 
								$field_value = (substr($field_value, strlen($field_value) - 1)==',')? $field_value = substr($field_value,0,-1):$field_value; 
								if($field_value==NULL) $field_value = '';
							}
							$batch[$k]['GROUPINGS'][] = array( 'id' => (int)$field->grouping_id, 'groups' => $field_value);
					}
				}
				
				$query = 'INSERT INTO #__joomailermailchimpintegration (userid,email,listid) VALUES ("'.$user[0]->id.'", "'.$user[0]->email.'", "'.$listId.'")';
				$db->setQuery($query);
				$db->query();
				$k++;
			} else {
				break;
			}

		}

				if($batch){
					$optin = false; //yes, send optin emails
					$up_exist = true; // yes, update currently subscribed users
					$replace_int = true; // false = add interest, don't replace
				//	var_dump($batch);die;
					$result = $MC->listBatchSubscribe($listId, $batch, $optin, $up_exist, $replace_int);
					$successCount = $successCount + $result['success_count'];
					if ( $result['error_count'] ) {
						foreach($result['errors'] as $e){
							$tmp = new stdClass;
							$tmp->errorCode = $e['code'];
							$tmp->errorMessage = $e['message'];
							$errorMsg .= '"'.$MCerrorHandler->getErrorMsg($tmp).'", ';
							
							$query = 'DELETE FROM #__joomailermailchimpintegration WHERE `listid` = "'.$listId.'" AND `email` = "'.$e['row']['EMAIL'].'" LIMIT 1';
							$db->setQuery($query);
							$db->query();
						}
						$msgErrorsCount += $result['error_count'];
					}
				}

	}

	if( $errorMsg ) {
		$msgErrors = substr($errorMsg,0,-2);
		$msgErrors = ' ( '.$msgErrorsCount.' '.JText::_('JM_ERRORS').': '.$msgErrors.' )';
	}
	$msg = $successCount.' '.JText::_( 'JM_RECIPIENTS_SAVED' ).$msgErrors;

    $link = 'index.php?option=com_joomailermailchimpintegration&view=sync';
	$this->setRedirect($link, $msg);

	}// function sync_all

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
	//	$msg = JText::_( 'JM_OPERATION_CANCELLED' );
		$msg = '';
		$this->setRedirect( 'index.php?option=com_joomailermailchimpintegration&view=sync', $msg );
	}// function
	
	
    function ajax_sync_all() {
	//		jimport( 'joomla.html.html.behavior' );
	//		JHTMLBehavior::keepalive();
		$elements = JRequest::getVar( 'elements', '', 'request', 'string' );
		$elements = json_decode($elements);
		if($elements->done == 0 ) {
			$_SESSION['abortAJAX'] = 0;
			unset($_SESSION['addedUsers']);
		}
	
		if($_SESSION['abortAJAX'] != 1){
	
			$params =& JComponentHelper::getParams( 'com_joomailermailchimpintegration' );
			$paramsPrefix = (version_compare(JVERSION,'1.6.0','ge')) ? 'params.' : '';
			$MCapi  = $params->get( $paramsPrefix.'MCapi' );
			$MC = new joomlamailerMCAPI($MCapi);
			$MCerrorHandler = new MCerrorHandler();
			
			$list_id  = $elements->listid;
			$step = $elements->step;
			
			$db     =& JFactory::getDBO();
			$model  =& $this->getModel('sync');

			if(isset($_SESSION['addedUsers'])){
				$exclude = $_SESSION['addedUsers'];
			} else {
				$exclude = array();
			}
			
			if( !$elements->failed ) { $elements->failed = array(); }
			$exclude = array_merge($exclude, $elements->failed);
			
			$exclude = implode('","', $exclude);
			$exclude = '"'.$exclude.'"';
	
			$query = 'SELECT id,email FROM #__users WHERE id NOT IN ('.$exclude.') AND block = 0 LIMIT '.$step;
			$db->setQuery($query);
			$data = $db->loadObjectList();
			
			$userIds = array();
			foreach($data as $dat){
				$userIds[$dat->email] = $dat->id;
			}
	
			// gather custom fields data
			$db	=& JFactory::getDBO();
			$query = "SELECT * FROM #__joomailermailchimpintegration_custom_fields WHERE listid = '".$list_id."' ";
			$db->setQuery($query);
			$custom_fields = $db->loadObjectList();
			if(!isset($custom_fields[0])) $custom_fields = false;
			
			
			$addedUsers = $elements->addedUsers;
			
			$m=0;
			$successCount = 0;
			$errorcount = $msgErrorsCount = 0;
			$msg = $msgErrors = false;
			
			$counter=0;
			$ids = '';
			$errorMsg = $elements->errorMsg;
			
		//	foreach ($data as $dat){
			for ($x=0;$x<count($data);$x+=$step){
				if($_SESSION['abortAJAX']==1) { unset($_SESSION['addedUsers']); break; }
				$k=0;
				$batch = array();
				$errorcount = $msgErrorsCount = 0;
				
				for ($y=$x;$y<($x+$step);$y++){
					if($_SESSION['abortAJAX']==1) { unset($_SESSION['addedUsers']); break; }
					
					if(isset($data[$y])){
						$dat = $data[$y];
					} else {
						$dat = false;
					}
					if($dat){
						$user = $model->getUser($dat->id);
						$addedUsers[] = $user[0]->id;
						$batch[$k]['EMAIL'] = $user[0]->email;
						// name
						$names = explode(' ', $user[0]->name);
						if( isset($names[0]) && isset($names[1]) ) {
							$batch[$k]['FNAME'] = $names[0];
							$batch[$k]['LNAME'] = '';
							for($i=1;$i<count($names);$i++){
								$batch[$k]['LNAME'] .= $names[$i].' ';
							}
						} else {
							$batch[$k]['FNAME'] = $user[0]->name;
						}
		
						$custom = array();
		
						if($custom_fields){
							foreach($custom_fields as $field){
								if($field->framework == 'CB') {
									$query = "SELECT ".$field->dbfield." FROM #__comprofiler WHERE user_id = '".$user[0]->id."' ";
								} else {
									$query = "SELECT value FROM #__community_fields_values WHERE field_id = ".$field->dbfield." AND user_id = '".$user[0]->id."' ";
								}
									$db->setQuery($query);
									$field_value = $db->loadResult();
									if($field->framework == 'CB') $field_value = str_replace('|*|', ',', $field_value);
									if($field->framework == 'JS') { 
										$field_value = (substr($field_value, strlen($field_value) - 1)==',')? $field_value = substr($field_value,0,-1):$field_value; 
										if($field_value==NULL) $field_value = '';
									}
									if($field->type=='group') {
										$batch[$k]['GROUPINGS'][] = array( 'id' => $field->grouping_id, 'groups' => $field_value);
									} else {
										$batch[$k][$field->grouping_id] = $field_value;
									}
								//	$batch[$k]['GROUPINGS'][] = array( 'id' => (int)$field->grouping_id, 'groups' => $field_value);
							}
						}
						$query = 'INSERT INTO #__joomailermailchimpintegration (userid,email,listid) VALUES ("'.$user[0]->id.'", "'.$user[0]->email.'", "'.$list_id.'")';
						$db->setQuery($query);
						$db->query();
						$k++;
					} else {
						break;
					}
				}
				if($batch){
				    $optin = false; //yes, send optin emails
				    $up_exist = true; // yes, update currently subscribed users
				    $replace_int = true; // false = add interest, don't replace
//				    var_dump($batch);die;
				    $result = $MC->listBatchSubscribe($list_id, $batch, $optin, $up_exist, $replace_int);
				    $successCount = $successCount + $result['success_count'];

				    if ( $result['error_count'] ) {
					foreach($result['errors'] as $e){
					    $tmp = new stdClass;
					    $tmp->errorCode = $e['code'];
					    $tmp->errorMessage = $e['message'];
					    $errorMsg .= '"'.$MCerrorHandler->getErrorMsg($tmp).' => '.$e['row']['EMAIL'].'", ';

					    $query = 'DELETE FROM #__joomailermailchimpintegration WHERE `listid` = "'.$list_id.'" AND `email` = "'.$e['row']['EMAIL'].'" LIMIT 1';
					    $db->setQuery($query);
					    $db->query();

					    $addedUsers = array_diff($addedUsers, array($userIds[$e['row']['EMAIL']]));

					    $elements->failed[] = $userIds[$e['row']['EMAIL']];
					    $errorcount++;
					}
					$msgErrorsCount += $result['error_count'];
				    }
				}
			}
	
				if( !count($data)) {
					$done = $elements->total;
					unset($_SESSION['addedUsers']);
					$percent = 100;
				} else {
					$done = count($addedUsers);
					$_SESSION['addedUsers'] = $addedUsers;
					$percent = ( $done / $elements->total ) * 100;
				}
		//		$response['msg'] = $done.'/'.$elements->total.' users added';
				$response['msg'] =   '<div id="bg"></div>'
						    .'<div style="background:#FFFFFF none repeat scroll 0 0;border:10px solid #000000;height:100px;left:37%;position:relative;text-align:center;top:37%;width:300px; ">'
						    .'<div style="margin: 35px auto 3px; width: 300px; text-align: center;">'.JText::_( 'JM_ADDING_USERS' ).' ( '.$done.'/'.$elements->total.' '.JText::_( 'JM_DONE' ).' )</div>'
						    .'<div style="margin: auto; background: transparent url('.JURI::root().'administrator/components/com_joomailermailchimpintegration/assets/images/progress_bar_grey.gif) repeat scroll 0% 0%; width: 190px; height: 14px; display: block;">'
						    .'<div style="width: '.$percent.'%; overflow: hidden;">'
						    .'<img src="'.JURI::root().'administrator/components/com_joomailermailchimpintegration/assets/images/progress_bar.gif" style="margin: 0 5px 0 0;"/>'

						    .'</div>'
						    .'<div style="width: 190px; text-align: center; position: relative;top:-13px; font-weight:bold;">'.round($percent,0).' %</div>'
						    .'</div>'
						    .'<a id="sbox-btn-close" style="text-indent:-5000px;right:-20px;top:-18px;outline:none;" href="javascript:abortAJAX();">abort</a>'
						    .'</div>';
		/*							
				$response['msg'] = '<div style="width: 190px; text-align: center">'.JText::_( 'adding users' ).' ( '.$done.'/'.$elements->total.' '.JText::_( 'done' ).')</div>'
						    .'<div style="background: transparent url('.JURI::root().'administrator/components/com_joomailermailchimpintegration/assets/images/progress_bar_grey.gif); width: 190px; height: 14px; display: block;">'
						    .'<div style="width: '.$percent.'%; overflow: hidden; background: transparent url('.JURI::root().'administrator/components/com_joomailermailchimpintegration/assets/images/progress_bar.gif);">'
						    .'</div>'
						    .'<div style="width: 190px; text-align: center; position: relative;">'.round($percent,0).' %</div>'
						    .'</div>';
		*/
				$response['done'] = $done;
				
				
			//	$msg = $successCount.' '.JText::_( 'JM_RECIPIENTS_SAVED' ).$msgErrors;
				
				$response['errors']	= count($elements->failed);
				$response['errorMsg']	= $errorMsg;
				$response['addedUsers']	= array_values($addedUsers);
				$response['failed']	= $elements->failed;
				
				if( ($done + count($elements->failed) +  $elements->errors) >= $elements->total ){
					$response['finished'] = 1;
					
					if( $errorMsg ) {
						$errorMsg  = substr($errorMsg,0,-2);
						$msgErrors = ' ( '.count($elements->failed).' '.JText::_('JM_ERRORS').': '.$errorMsg.' )';
					}
					if ( !$msg ) { $msg = $done.' '.JText::_( 'JM_RECIPIENTS_SAVED' ); }
					if ( $msgErrors ) { $msg .= $msgErrors; }
					$response['finalMessage'] = $msg;
					
				} else {
					$response['finished'] = 0;
					$response['finalMessage'] = '';
				}
				$response['abortAJAX'] = $_SESSION['abortAJAX'];
			echo json_encode( $response );
		} else {
			unset($_SESSION['addedUsers']);
			$response['finished'] = 1;
			$response['addedUsers'] = '';
			$response['abortAJAX'] = $_SESSION['abortAJAX'];
			echo json_encode( $response );
		}
	} // function
	
	function abortAJAX(){
		
		$_SESSION['abortAJAX'] = 1;
		$response['finalMessage'] = JText::_( 'JM_OPERATION_CANCELLED' );
		echo json_encode( $response );
	}
	
	
	
	
	function getTotal(){
		
		$db       =& JFactory::getDBO();
		$elements = JRequest::getVar( 'elements', '', 'request', 'string' );
		$elements = json_decode($elements);
		$list_id  = $elements->listid;

		$query = 'SELECT count(id) FROM #__users WHERE block = 0 ';
		$db->setQuery($query);
		$total = $db->loadResult();

		$response['total'] = $total;
		echo json_encode( $response );
	}
	
	
	function get_subs(){
		
		$elements = JRequest::getVar( 'elements', '', 'request', 'string' );
		$elements = json_decode($elements);
		$list_id  = $elements->listid;
		
		$db	=& JFactory::getDBO();
		$query = "SELECT userid FROM #__joomailermailchimpintegration WHERE listid = '".$list_id."' ";
		$db->setQuery($query);
		$response['uids'] = $db->loadResultArray();

		echo json_encode( $response );
	}
	
	
	function setConfig(){
		
	    $crm = JRequest::getVar('crm');

	    $crmFields = JRequest::getVar('crmFields');
	    $params = json_encode($crmFields);

	    $db	=& JFactory::getDBO();
	    $query = "DELETE FROM #__joomailermailchimpintegration_crm WHERE crm = '$crm'";
	    $db->setQuery($query);
	    $db->query();
	    $query = "INSERT INTO #__joomailermailchimpintegration_crm (crm, params) VALUES ('$crm', '".$params."')";
	    $db->setQuery($query);
	    $db->query();

	    $msg = JText::_( 'JM_CONFIGURATION_SAVED' );
	    $this->setRedirect( 'index.php?option=com_joomailermailchimpintegration&view=sync', $msg );
	}

	function sync_highrise(){
		
	    $db	=& JFactory::getDBO();
	    $params =& JComponentHelper::getParams( 'com_joomailermailchimpintegration' );
	    $paramsPrefix = (version_compare(JVERSION,'1.6.0','ge')) ? 'params.' : '';
	    $highrise_url = $params->get( $paramsPrefix.'highrise_url' );
	    $highrise_api_token = $params->get( $paramsPrefix.'highrise_api_token' );

	    $model  =& $this->getModel('sync');
	    $config =& $model->getConfig('highrise');

	    if( $config == NULL ){
		jimport( 'joomla.application.component.helper' );
		$cHelper = JComponentHelper::getComponent( 'com_comprofiler', false );
		$cbInstalled = $cHelper->enabled;

		$config = new stdClass();
		$config->{'first-name'} = ($cbInstalled) ? 'CB' : 'core';
		$config->email_work = 'default';
	    }

	    $validator = new EmailAddressValidator;

	    $elements = JRequest::getVar( 'elements', '', 'request', 'string' );
	    $elements = json_decode($elements);
	    if($elements->done == 0 ) {
		$_SESSION['abortAJAX'] = 0;
		unset($_SESSION['addedUsers']);
	    }

	    $failed = $elements->errors;
	    $errorMsg = $elements->errorMsg;
	    $step = $elements->step;

	    if($_SESSION['abortAJAX'] != 1){

	    if(isset($_SESSION['addedUsers'])){
		$exclude = $_SESSION['addedUsers'];
	    } else {
		$exclude = array();
	    }

	    $addedUsers = $exclude;
	    if( isset($exclude[0]) ){
		$exclude = implode('","', $exclude);
		$exclude = '"'.$exclude.'"';
		$excludeCond = 'AND id NOT IN ('.$exclude.') ';
	    } else {
		$excludeCond = '';
	    }

	    if( $elements->range == 'all' ){
		$query = 'SELECT * FROM #__users '
			.'WHERE block = 0 '
			.$excludeCond
			.'ORDER BY id '
			.'LIMIT '.$step;
	    } else {
		$idList = implode( " OR id = ", $elements->cid);
		$query = 'SELECT * FROM #__users '
			.'WHERE block = 0 '
			.$excludeCond
			.'AND ( id = '.$idList.' ) '
			.'ORDER BY id ';
	    }
	    $db->setQuery($query);
	    $users = $db->loadObjectList();

	    $queryJS = false;
	    $queryCB = false;
	    $JSand = array();
	    foreach( $config as $k => $v ){
		if( $k != 'first-name' && $k != 'last-name' ){
		    $vEx = explode(';', $v);
		    if( $vEx[0] == 'js' ) {
			$queryJS = true;
			$JSand[] = $vEx[1];
		    } else if ( $vEx[0] == 'CB' ) {
			$queryCB = true;
		    }
		}
	    }
	    $JSand = implode("','", array_unique($JSand) );

	    require_once(JPATH_ADMINISTRATOR.'/components/com_joomailermailchimpintegration/libraries/push2Highrise.php');
	    $highrise = new Push_Highrise($highrise_url, $highrise_api_token);

	    $data = array();
	    $emails = array();
	    $x = 0;
	    $new = $elements->new;
	    $updated = $elements->updated;
	    $userIDs = array();
	    foreach($users as $user){
		if( $validator->check_email_address( $user->email ) ){
		    $request = array();
		    $userCB = false;

		    $names = explode(' ', $user->name);
		    $firstname = $names[0];
		    $lastname = '';
		    if(isset($names[1])){
			for($i=1;$i<count($names);$i++){
			    $lastname .= $names[$i].' ';
			}
		    }
		    $lastname = trim($lastname);
		    
		    if( $config->{'first-name'} != 'core' ) {
			$query = "SELECT * FROM #__comprofiler WHERE user_id = '$user->id'";
			$db->setQuery($query);
			$userCB = $db->loadObjectList();

			$firstname = ($userCB[0]->firstname) ? $userCB[0]->firstname : $firstname;
			$lastname  = ($userCB[0]->lastname) ? $userCB[0]->lastname : $lastname;
			if( $userCB[0]->middlename != '' ){
			    $lastname = $userCB[0]->middlename.' '.$lastname;
			}
		    }
		    
		    $highriseUser = $highrise->person_in_highrise( array( 'first-name' => $firstname, 'last-name' => $lastname) );
		    $request['id'] = $highriseUser->id;
	//	    var_dump($highriseUser);die;

		    if( $queryJS ){
			$query = "SELECT field_id, value FROM #__community_fields_values ".
				 "WHERE user_id = '$user->id' ".
				 "AND field_id IN ('$JSand')";
			$db->setQuery($query);
			$JSfields = $db->loadObjectList();
			$JSfieldsArray = array();
			foreach($JSfields as $jsf){
			    $JSfieldsArray[$jsf->field_id] = $jsf->value;
			}
		    }

		    if( $queryCB ){
			if( !$userCB ){
			    $query = "SELECT * FROM #__comprofiler WHERE user_id = '$user->id'";
			    $db->setQuery($query);
			    $userCB = $db->loadObjectList();
			}
		    }

		    $xml =  "<person>\n";

		    if( (int)$highriseUser->id > 0){
			$xml .= '<id>'.$highriseUser->id."</id>\n";
		    }

		    $xml .=  "<first-name>".htmlspecialchars($firstname)."</first-name>\n"
			    ."<last-name>".htmlspecialchars($lastname)."</last-name>";

		    
		    if( isset($config->title) && $config->title != '' ){
			$conf = explode(';', $config->title);
			$value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');
			$xml .= "\n<title>".htmlspecialchars($value)."</title>";
		    }
		    if( isset($config->background) && $config->background != '' ){
			$conf = explode(';', $config->background);
			$value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');
			$xml .= "\n<background>".htmlspecialchars($value)."</background>";
		    }
		    if( isset($config->company) && $config->company != '' ){
			$conf = explode(';', $config->company);
			$value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');
			$xml .= "\n<company-name>".htmlspecialchars($value).'</company-name>';
		    }

		    
		    $xml .= "\n<contact-data>";
		    $xml .= "\n<email-addresses>";

		    $emailTypes = array( 'work', 'home', 'other' );
		    foreach ($emailTypes as $et){

			if( isset($config->{'email_'.$et}) && $config->{'email_'.$et} != '' ){
			if($config->{'email_'.$et} == 'default'){
			    $value = $user->email;
			} else {
			    $conf = explode(';', $config->{'email_'.$et});
			    $value = ( $conf[0] == 'js' ) ?  $JSfieldsArray[$conf[1]] : $userCB[0]->{$conf[1]};
			}

			$fieldId = '';
			if( isset($highriseUser->{'contact-data'}->{'email-addresses'}->{'email-address'}) ){
			foreach( $highriseUser->{'contact-data'}->{'email-addresses'} as $hu){
			    foreach( $hu->{'email-address'} as $ea){
				if( $ea->location == ucfirst($et) ){
				    $fieldId = '<id type="integer">'.$ea->id[0]."</id>\n";
				    break;
				}
			    }
			}
			}
			$xml .= "\n<email-address>\n"
				    .$fieldId
				    ."<address>".htmlspecialchars($value)."</address>\n"
				    ."<location>".ucfirst($et)."</location>\n"
				."</email-address>";
			}


		    }
		    
		    $xml .= "\n</email-addresses>\n";

		    $xml .= "\n<phone-numbers>\n";
		    $phoneTypes = array('work','mobile','fax','pager','home','skype','other');
		    foreach($phoneTypes as $pt){
			if( $config->{'phone_'.$pt} != NULL && $config->{'phone_'.$pt} != '' ){
			    $conf = explode(';', $config->{'phone_'.$pt});
			    $value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');

			    $fieldId = '';
			    if( isset($highriseUser->{'contact-data'}->{'phone-numbers'}->{'phone-number'}) ){
			    foreach( $highriseUser->{'contact-data'}->{'phone-numbers'} as $hu){
				foreach( $hu->{'phone-number'} as $pn){
				    if( $pn->location == ucfirst($pt) ){
					$fieldId = '<id type="integer">'.$pn->id[0]."</id>\n";
					break;
				    }
				}
			    }
			    }
			    $xml .= "<phone-number>\n"
					.$fieldId
					."<number>".htmlspecialchars($value)."</number>\n"
					."<location>".ucfirst($pt)."</location>\n"
				    ."</phone-number>";
			}
		    }
		    $xml .= "\n</phone-numbers>\n";

		    $xml .= "\n<instant-messengers>\n";
		    $imTypes = array('AIM','MSN','ICQ','Jabber','Yahoo','Skype','QQ','Sametime','Gadu-Gadu','Google Talk','Other');
		    foreach($imTypes as $im){
			if( isset($config->{$im}) && $config->{$im} != '' ){
			    $value = false;
			    if( $config->{$im} == 'default' ){
				$value = $user->email;
			    } else if( $config->{$im} != '' ){
				$conf = explode(';', $config->{$im});
				$value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');
			    }
			    if( $value ){
				$fieldId = '';
				if( isset($highriseUser->{'contact-data'}->{'instant-messengers'}->{'instant-messenger'}) ){
				foreach( $highriseUser->{'contact-data'}->{'instant-messengers'} as $imx){
				    foreach( $imx->{'instant-messenger'} as $ia){
					if( $ia->protocol == $im ){
					    $fieldId = '<id type="integer">'.$ia->id[0]."</id>\n";
					    break;
					}
				    }
				}
				}
				$xml .= "<instant-messenger>\n"
					    .$fieldId
					    ."<address>".htmlspecialchars($value)."</address>\n"
					    ."<location>Work</location>\n"
					    ."<protocol>".$im."</protocol>\n"
					."</instant-messenger>";
			    }
			}
		    }
		    $xml .= "\n</instant-messengers>\n";

		    if( isset($config->website) && $config->website != '' ){
		    $xml .= "\n<web-addresses>\n";
		    $conf = explode(';', $config->website);
		    $value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');

		    $fieldId = '';
		    if( isset($highriseUser->{'contact-data'}->{'web-addresses'}->{'web-address'}) ){
		    foreach( $highriseUser->{'contact-data'}->{'web-addresses'} as $ws){
			foreach( $ws->{'web-address'} as $wa){
			    if( $wa->location == 'Work' ){
				$fieldId = '<id type="integer">'.$wa->id[0]."</id>\n";
				break;
			    }
			}
		    }
		    }
		    $xml .= "<web-address>\n"
				.$fieldId
				."<url>".htmlspecialchars($value)."</url>\n"
				."<location>Work</location>\n"
			    ."</web-address>";
		    $xml .= "\n</web-addresses>\n";
		    }

		    if( isset($config->twitter) && $config->twitter != '' ){
		    $xml .= "\n<twitter-accounts>\n";
		    $conf = explode(';', $config->twitter);
		    $value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');
		    $value = removeSpecialCharacters( $value );
		    $fieldId = '';
		    if( isset($highriseUser->{'contact-data'}->{'twitter-accounts'}->{'twitter-account'}) ){
		    foreach( $highriseUser->{'contact-data'}->{'twitter-accounts'} as $tac){
			foreach( $tac->{'twitter-account'} as $ta){
			    if( $ta->location == 'Personal' ){
				$fieldId = '<id type="integer">'.$ta->id[0]."</id>\n";
				break;
			    }
			}
		    }
		    }
		    $xml .= "<twitter-account>\n"
				.$fieldId
				."<username>".htmlspecialchars( str_replace(' ','',$value) )."</username>\n"
				."<location>Personal</location>\n"
			    ."</twitter-account>";
		    $xml .= "\n</twitter-accounts>\n";
		    }

		    if(    ( isset($config->street) && $config->street != '' )
			|| ( isset($config->city)   && $config->city != ''   )
			|| ( isset($config->zip)    && $config->zip != ''    )
			|| ( isset($config->state)  && $config->state != ''  )
			|| ( isset($config->country)&& $config->country != '')
		      ){
			$xml .= "\n<addresses>\n";
			$xml .= "<address>\n";

			$fieldId = '';
			if( isset($highriseUser->{'contact-data'}->addresses->address) ){
			foreach( $highriseUser->{'contact-data'}->addresses as $ads){
			    foreach( $ads->address as $ad){
				if( $ad->location == 'Work' ){
				    $fieldId = '<id type="integer">'.$ad->id[0]."</id>\n";
				    break;
				}
			    }
			}
			}
			$xml .= $fieldId;

			if( isset($config->street) && $config->street != '' ) {
			    $conf = explode(';', $config->street);
			    $value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');
			    $xml .= "<street>".htmlspecialchars($value)."</street>\n";
			}
			if( isset($config->city)   && $config->city != '' ) {
			    $conf = explode(';', $config->city);
			    $value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');
			    $xml .= "<city>".htmlspecialchars($value)."</city>\n";
			}
			if( isset($config->zip)    && $config->zip != '' ) {
			    $conf = explode(';', $config->zip);
			    $value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');
			    $xml .= "<zip>".htmlspecialchars($value)."</zip>\n";
			}
			if( isset($config->state)  && $config->state != '' ) {
			    $conf = explode(';', $config->state);
			    $value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');
			    $xml .= "<state>".htmlspecialchars($value)."</state>\n";
			}
			if( isset($config->country) && $config->country != '' ) {
			    $conf = explode(';', $config->country);
			    $value = ( $conf[0] == 'js' ) ?  ( (isset($JSfieldsArray[$conf[1]]))?$JSfieldsArray[$conf[1]]:'') : ((isset($userCB[0]->{$conf[1]}))?$userCB[0]->{$conf[1]}:'');
			    $xml .= "<country>".htmlspecialchars($value)."</country>\n";
			}

			$xml .= "<location>Work</location>\n";
			$xml .= "</address>\n";
			$xml .= "</addresses>\n";
		    }



		    $xml .= "\n</contact-data>";
		
		    $xml .= "\n</person>";

		    $request['xml'] = $xml;

		    $apiResult = $highrise->pushContact($request);

		    if( $apiResult['status'] != 200 && $apiResult['status'] != 201 ){
			// error
			$failed++;
			$errorMsg .= '"Server returned error code '.$apiResult['status'].' for user '.$user->name.' (ID '.$user->id.')", ';
			$apiResult['newContacts'] = 0;
			$apiResult['updated'] = 0;
		    } else {
			// success
			$query = "INSERT INTO #__joomailermailchimpintegration_crm_users "
				."(crm, user_id) VALUES "
				."('highrise', '$user->id.')";
			$db->setQuery($query);
			$db->query();

			$addedUsers[] = $user->id;
		    }

		} else {
		    $failed++;
		    $errorMsg .= '"Invalid email => '.$user->email.' ('.$user->name.' - ID '.$user->id.')", ';
		    $apiResult['newContacts'] = 0;
		    $apiResult['updated'] = 0;
		}
	    }

	    } else {
		unset($_SESSION['addedUsers']);
		$response['finished'] = 1;
		$response['addedUsers'] = '';
		$response['abortAJAX'] = $_SESSION['abortAJAX'];
		echo json_encode( $response );
	    }

	    if( !count($users)) {
		$done = $elements->total;
		unset($_SESSION['addedUsers']);
		$percent = 100;
	    } else {
		$done = count($addedUsers);
		$_SESSION['addedUsers'] = $addedUsers;
		$percent = ( $done / $elements->total ) * 100;
	    }

	    $response['msg'] =   '<div id="bg"></div>'
				.'<div style="background:#FFFFFF none repeat scroll 0 0;border:10px solid #000000;height:100px;left:37%;position:relative;text-align:center;top:37%;width:300px; ">'
				.'<div style="margin: 35px auto 3px; width: 300px; text-align: center;">'.JText::_( 'JM_ADDING_USERS' ).' ( '.$done.'/'.$elements->total.' '.JText::_( 'JM_DONE' ).' )</div>'
				.'<div style="margin: auto; background: transparent url('.JURI::root().'administrator/components/com_joomailermailchimpintegration/assets/images/progress_bar_grey.gif) repeat scroll 0% 0%; width: 190px; height: 14px; display: block;">'
				.'<div style="width: '.$percent.'%; overflow: hidden;">'
				.'<img src="'.JURI::root().'administrator/components/com_joomailermailchimpintegration/assets/images/progress_bar.gif" style="margin: 0 5px 0 0;"/>'

				.'</div>'
				.'<div style="width: 190px; text-align: center; position: relative;top:-13px; font-weight:bold;">'.round($percent,0).' %</div>'
				.'</div>'
				.'<a id="sbox-btn-close" style="text-indent:-5000px;right:-20px;top:-18px;outline:none;" href="javascript:abortAJAX();">abort</a>'
				.'</div>';

	    $response['done']	    = $done;
	    $response['newContacts']= $new + $apiResult['new'];
	    $response['updated']    = $updated + $apiResult['updated'];
	    $response['errors']	    = $failed;
	    $response['errorMsg']   = $errorMsg;


	    if( ($done + $failed) >= $elements->total ){
		unset($_SESSION['addedUsers']);
		$response['finished'] = 1;

		if( $errorMsg ) {
		    $errorMsg  = substr($errorMsg,0,-2);
		    $msgErrors = ' ; '.$failed.' '.JText::_('JM_ERRORS').': '.$errorMsg.' ';
		}
		$msg = ($done + $failed).' '.JText::_( 'JM_USERS_PROCESSED' );

		$msg .= ' ( '.$response['newContacts'].' '.JText::_('JM_NEW').' ; '.$response['updated'].' '.JText::_('JM_UPDATED').' ';
		if ( isset($msgErrors) && $msgErrors ) { $msg .= $msgErrors; }
		$msg .= ')';
		$response['finalMessage'] = $msg;

	    } else {
		$response['finished'] = 0;
		$response['finalMessage'] = '';
	    }
	    $response['abortAJAX'] = $_SESSION['abortAJAX'];

	    echo json_encode( $response );
	}

	function ajax_sync_sugar() {

	    $db	=& JFactory::getDBO();
	    $params =& JComponentHelper::getParams( 'com_joomailermailchimpintegration' );
	    $paramsPrefix = (version_compare(JVERSION,'1.6.0','ge')) ? 'params.' : '';
	    $sugar_name = $params->get( $paramsPrefix.'sugar_name' );
	    $sugar_pwd  = $params->get( $paramsPrefix.'sugar_pwd' );
	    $sugar_url  = $params->get( $paramsPrefix.'sugar_url' );

	    $model  =& $this->getModel('sync');
	    $config =& $model->getConfig('sugar');

	    if( $config == NULL ){
		jimport( 'joomla.application.component.helper' );
		$cHelper = JComponentHelper::getComponent( 'com_comprofiler', true );
		$cbInstalled = $cHelper->enabled;

		$config = new stdClass();
		$config->first_name = ($cbInstalled) ? 'CB' : 'core';
	    }

	    $validator = new EmailAddressValidator;

	    require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomailermailchimpintegration'.DS.'libraries'.DS.'sugar.php');

	    $sugar = new SugarCRMWebServices;
	    $sugar->SugarCRM( $sugar_name, $sugar_pwd, $sugar_url );
	    $sugar->login();

	    $elements = JRequest::getVar( 'elements', '', 'request', 'string' );
	    $elements = json_decode($elements);
	    if($elements->done == 0 ) {
		$_SESSION['abortAJAX'] = 0;
		unset($_SESSION['addedUsers']);
	    }

	    $failed = $elements->errors;
	    $errorMsg = $elements->errorMsg;
	    $step = $elements->step;

	    if($_SESSION['abortAJAX'] != 1){
	
		if(isset($_SESSION['addedUsers'])){
		    $exclude = $_SESSION['addedUsers'];
		} else {
		    $exclude = array();
		}

		$addedUsers = $exclude;
		if( isset($exclude[0]) ){
		    $exclude = implode('","', $exclude);
		    $exclude = '"'.$exclude.'"';
		    $excludeCond = 'AND id NOT IN ('.$exclude.') ';
		} else {
		    $excludeCond = '';
		}

		if( $elements->range == 'all' ){
		    $query = 'SELECT * FROM #__users '
			    .'WHERE block = 0 '
			    .$excludeCond
			    .'ORDER BY id '
			    .'LIMIT '.$step;

		} else {

		    $idList = implode( " OR id = ", $elements->cid);

		    $query = 'SELECT * FROM #__users '
			    .'WHERE block = 0 '
			    .$excludeCond
			    .'AND ( id = '.$idList.' ) '
			    .'ORDER BY id ';
		}
		$db->setQuery($query);
		$users = $db->loadObjectList();

		$queryJS = false;
		$queryCB = false;
		$JSand = array();
		foreach( $config as $k => $v ){
		    if( $k != 'firstname' && $k != 'lastname' ){
			$vEx = explode(';', $v);
			if( $vEx[0] == 'js' ) {
			    $queryJS = true;
			    $JSand[] = $vEx[1];
			} else if( $vEx[0] == 'CB' ){
			    $queryCB = true;
			}
		    }
		}
		$JSand = implode("','", array_unique($JSand) );

		$data = array();
		$emails = array();
		$x = 0;
		$new = $elements->new;
		$updated = $elements->updated;
		$userIDs = array();
		foreach( $users as $user ){
		    if( $validator->check_email_address( $user->email ) ){

			$userCB = false;

			if( $config->first_name == 'core' ){
			    $names = explode(' ', $user->name);
			    $first_name = $names[0];
			    $last_name = '';
			    if(isset($names[1])){
				for($i=1;$i<count($names);$i++){
				    $last_name .= $names[$i].' ';
				}
			    }
			    $last_name = trim($last_name);
			} else {
			    $query = "SELECT * FROM #__comprofiler WHERE user_id = '$user->id'";
			    $db->setQuery($query);
			    $userCB = $db->loadObjectList();

			    $first_name = $userCB[0]->firstname;
			    $last_name  = $userCB[0]->lastname;
			    if( $userCB[0]->middlename != '' ){
				$last_name = $userCB[0]->middlename.' '.$last_name;
			    }
			}
		//	var_dump($first_name, $last_name);
			if( $queryJS ){
			    $query = "SELECT field_id, value FROM #__community_fields_values ".
				     "WHERE user_id = '$user->id' ".
				     "AND field_id IN ('$JSand')";
			    $db->setQuery($query);
			    $JSfields = $db->loadObjectList();
			    $JSfieldsArray = array();
			    foreach($JSfields as $jsf){
				$JSfieldsArray[$jsf->field_id] = $jsf->value;
			    }
			}

			if( $queryCB ){
			    if( !$userCB ){
				$query = "SELECT * FROM #__comprofiler WHERE user_id = '$user->id'";
				$db->setQuery($query);
				$userCB = $db->loadObjectList();
			    }
			}


			$data[$x] = array('first_name'	=> $first_name,
					  'last_name'	=> $last_name,
					  'email1'	=> $user->email
					 );


			foreach( $config as $k => $v ){
			    if( $k != 'first_name' && $k != 'last_name' ){
				if( $v ){
				    $vEx = explode(';', $v);
				    if($vEx[0] == 'js' ) {
					$data[$x][$k] = ( isset($JSfieldsArray[$vEx[1]]) ) ? $JSfieldsArray[$vEx[1]] : '';
				    } else {
					$data[$x][$k] = ( isset( $userCB[0]->{$vEx[1]} ) ) ? str_replace('|*|',', ',$userCB[0]->{$vEx[1]}) : '';
				    }
				}

			    }
			}
			
			$emails[$x] = $user->email;
			$userIDs[] = $user->id;
			$x++;
		    } else {
			$errorMsg .= '"Invalid email => '.$user->email.'", ';
			$failed++;
		    }
		    $addedUsers[] = $user->id;
		}

		if( isset( $emails[0] )){
		    $existing_users = $sugar->findUserByEmail( $emails );
		} else {
		    $existing_users = array();
		}

		$sendData = array();
		$x = 0;
		foreach($data as $d){
		    $sendData[$x] = $d;
		    if( isset( $existing_users[ $d['email1'] ] ) ){
			$sendData[$x]['id'] = $existing_users[ $d['email1'] ];
			$updated++;
		    } else {
			$new++;
		    }
		    $x++;
		}

		$sugarResult = $sugar->setContactMulti($sendData);

		if( $sugarResult !== false && isset( $userIDs[0] ) ){
		    $userIDsInserts = array();
		    foreach($userIDs as $uid){
			$userIDsInserts[] = "('sugar', '$uid')";
		    }
		    $userIDsInsert = implode(', ', $userIDsInserts);
		    $query = "INSERT INTO #__joomailermailchimpintegration_crm_users "
			    ."(crm, user_id) VALUES "
			    .$userIDsInsert;
		    $db->setQuery($query);
		    $db->query();
		}

	    } else {
		unset($_SESSION['addedUsers']);
		$response['finished'] = 1;
		$response['addedUsers'] = '';
		$response['abortAJAX'] = $_SESSION['abortAJAX'];
		echo json_encode( $response );
	    }

	    if( !count($users)) {
		$done = $elements->total;
		unset($_SESSION['addedUsers']);
		$percent = 100;
	    } else {
		$done = count($addedUsers);
		$_SESSION['addedUsers'] = $addedUsers;
		$percent = ( $done / $elements->total ) * 100;
	    }

	    $response['msg'] =   '<div id="bg"></div>'
				.'<div style="background:#FFFFFF none repeat scroll 0 0;border:10px solid #000000;height:100px;left:37%;position:relative;text-align:center;top:37%;width:300px; ">'
				.'<div style="margin: 35px auto 3px; width: 300px; text-align: center;">'.JText::_( 'JM_ADDING_USERS' ).' ( '.$done.'/'.$elements->total.' '.JText::_( 'JM_DONE' ).' )</div>'
				.'<div style="margin: auto; background: transparent url('.JURI::root().'administrator/components/com_joomailermailchimpintegration/assets/images/progress_bar_grey.gif) repeat scroll 0% 0%; width: 190px; height: 14px; display: block;">'
				.'<div style="width: '.$percent.'%; overflow: hidden;">'
				.'<img src="'.JURI::root().'administrator/components/com_joomailermailchimpintegration/assets/images/progress_bar.gif" style="margin: 0 5px 0 0;"/>'

				.'</div>'
				.'<div style="width: 190px; text-align: center; position: relative;top:-13px; font-weight:bold;">'.round($percent,0).' %</div>'
				.'</div>'
				.'<a id="sbox-btn-close" style="text-indent:-5000px;right:-20px;top:-18px;outline:none;" href="javascript:abortAJAX();">abort</a>'
				.'</div>';

	    $response['done']	    = $elements->run++;
	    $response['done']	    = $done;
	    $response['newUser']    = $new;
	    $response['updated']    = $updated;
	    $response['errors']	    = $failed;
	    $response['errorMsg']   = $errorMsg;


	    if( ($done + $failed) >= $elements->total ){
		unset($_SESSION['addedUsers']);
		$response['finished'] = 1;

		if( $errorMsg ) {
		    $errorMsg  = substr($errorMsg,0,-2);
		    $msgErrors = ' ; '.$failed.' '.JText::_('JM_ERRORS').': '.$errorMsg.' ';
		}
		$msg = $done.' '.JText::_( 'JM_USERS_PROCESSED' );

		$msg .= ' ( '.$new.' '.JText::_('JM_NEW').' ; '.$updated.' '.JText::_('JM_UPDATED').' ';
		if ( isset($msgErrors) && $msgErrors ) { $msg .= $msgErrors; }
		$msg .= ')';
		$response['finalMessage'] = $msg;

	    } else {
		$response['finished'] = 0;
		$response['finalMessage'] = '';
	    }
	    $response['abortAJAX'] = $_SESSION['abortAJAX'];
	    echo json_encode( $response );
	}

}// class
