<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

// no direct access
defined('_JEXEC') or die; 

/**
 * LPs administrator helper.
 */
class LpsHelper
{

	public static function isValueNumeric($value) {
	    if ($value == (string) (float) $value) {
	        return (bool) is_numeric($value);
	    }
	    if ($value >= 0 && is_string($value) && !is_float($value)) {
	        return (bool) ctype_digit($value);
	    }
	    return (bool) is_numeric($value);
	}

	public static function getLeads() {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_leads`";
		$db->setQuery($sql);
		return $db->loadObjectList();        
    }

	public static function getTemplates() {
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM `#__lps_templates`";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}

	public static function getTemplate($id) {
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM `#__lps_templates` WHERE `id`=".$id;
		$db->setQuery($sql);
		return $db->loadObject();
	}

	public static function getFormItems() {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_forms`";
        $db->setQuery($sql);
        return $db->loadObjectList();
	}

	public static function getForm($id) {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_forms` WHERE `id`=".$id;
        $db->setQuery($sql);
        return $db->loadObject();
	}

	public static function translateFormTypes($typeName) {
		switch ($typeName) {
			case 'text_box':
					$txt = JText::_('COM_LPS_FIELDS_TEXTBOX_FIELD_TYPE');
				break;
			case 'text_area':
					$txt = JText::_('COM_LPS_FIELDS_TEXTAREA_FIELD_TYPE');
				break;
			case 'select_list':
					$txt = JText::_('COM_LPS_FIELDS_SELECT_LIST_FIELD_TYPE');
				break;
			case 'checkbox_group':
					$txt = JText::_('COM_LPS_FIELDS_CHECKBOX_GROUP_FIELD_TYPE');
				break;
			case 'radio_group':
					$txt = JText::_('COM_LPS_FIELDS_RADIO_GROUP_FIELD_TYPE');
				break;
			case 'calendar':
					$txt = JText::_('COM_LPS_FIELDS_CALENDAR_FIELD_TYPE');
				break;
			case 'button':
					$txt = JText::_('COM_LPS_FIELDS_BUTTON_FIELD_TYPE');
				break;
			case 'free_text':
					$txt = JText::_('COM_LPS_FIELDS_FREETEXT_FIELD_TYPE');
				break;
			case 'submit_button':
					$txt = JText::_('COM_LPS_FIELDS_SUBMIT_BUTTON_FIELD_TYPE');
				break;
			default:
					$txt = '';
				break;
		}

		return $txt;
	}

	public static function getFieldName($fieldId) {
		$db = JFactory::getDBO();
		$sql = "SELECT `property_value` FROM `#__lps_field_properties` WHERE `property_name`='NAME' AND `field_id`=".$fieldId;
		$db->setQuery($sql);
		return $db->loadResult();
	}

	public static function getFieldOrdering($formId) {
		$db = JFactory::getDBO();
		$sql = "SELECT `id`, `order` 
				FROM `#__lps_fields` 
				WHERE `form_id`=".$formId." 
				AND `type_id` !=10 
				AND `type_id` !=11 
				ORDER BY `order` ASC";
		$db->setQuery($sql);
		$fields = $db->loadObjectList();
		if (count($fields) > 0) {
			$orderedFieldList = array();
			foreach ($fields as $field) {
				$orderedFieldList[$field->id] = $field->order;
			}
			return $orderedFieldList;
		} else {
			return array();
		}
	}

	public static function getTypeName($typeId) {
		$db = JFactory::getDBO();
		$sql = "SELECT `name` FROM `#__lps_field_types` WHERE `id`=".$typeId;
		$db->setQuery($sql);
		return $db->loadResult();
	}

	public static function getTemplateLayoutContent($layout) {
		if ($layout == 'codeyourown') {
			$tmpl = new stdClass;
			$tmpl->name = "Code Your Own";
			$tmpl->src = "components/com_lps/assets/images/layouts/codeyourown_layout.png";
		} else if ($layout == 'onecolumn') {
			$tmpl = new stdClass;
			$tmpl->name = "1 Column";
			$tmpl->src = "components/com_lps/assets/images/layouts/1column_layout.png";
		} else if ($layout == 'leftsidebar') {
			$tmpl = new stdClass;
			$tmpl->name = "Left Sidebar";
			$tmpl->src = "components/com_lps/assets/images/layouts/leftsidebar_layout.png";
		} else if ($layout == 'rightsidebar') {
			$tmpl = new stdClass;
			$tmpl->name = "Right Sidebar";
			$tmpl->src = "components/com_lps/assets/images/layouts/rightsidebar_layout.png";
		} else if ($layout == 'twocolumn') {		
			$tmpl = new stdClass;
			$tmpl->name = "2 Column";
			$tmpl->src = "components/com_lps/assets/images/layouts/2column_layout.png";
		} else if ($layout == 'threecolumn') {		
			$tmpl = new stdClass;
			$tmpl->name = "3 Column";
			$tmpl->src = "components/com_lps/assets/images/layouts/3column_layout.png";
		} else if ($layout == 'threecolumnrepeat') {				
			$tmpl = new stdClass;
			$tmpl->name = "3 Column Repeat";
			$tmpl->src = "components/com_lps/assets/images/layouts/3columnrepeat_layout.png";
		} else {
			return false;
		}

		return $tmpl;
	}

	public static function formatDate($dateString) {
		return date('n/j/Y g:i a',strtotime($dateString));
	}

	public static function getLpSubmissionCount($lpId) {
		$db = JFactory::getDBO();
		$sql = "SELECT COUNT(`id`) FROM `#__lps_submissions` WHERE `lp_id`=".$lpId;
		$db->setQuery($sql);
		return $db->loadResult();
	}

	public static function getLpSubmissions($lpId) {
		$db = JFactory::getDBO();
		$sql = "SELECT `id` FROM `#__lps_submissions` WHERE `lp_id`=".$lpId;
		$db->setQuery($sql);
		return $db->loadObjectList();
	}

	public static function getLpSubmissionLeadCount($lpId) {
		$submissions = self::getLpSubmissions($lpId);
		$db = JFactory::getDBO();

		if (count($submissions) > 0) {
			$submissionIdList = array();
			foreach ($submissions as $key => $submission) {
				$submissionIdList[] = $submission->id;
			}
			$sql = "SELECT COUNT(*) FROM `#__lps_leads` WHERE `submission_id` IN (".implode(',',$submissionIdList).")";
			$db->setQuery($sql);
			return $db->loadResult();
		} else {
			return 0;
		}


	}

	public static function getJavascriptFileLanguage() {

		$language = new stdClass;
		$language->COM_LPS_LANDING_PAGES_CONFIRM_REMOVE = JText::_('COM_LPS_LANDING_PAGES_CONFIRM_REMOVE');
		$language->COM_LPS_TEMPLATES_CONFIRM_REMOVE = JText::_('COM_LPS_TEMPLATES_CONFIRM_REMOVE');
		$language->COM_LPS_TEMPLATES_CONFIRM_LAYOUT_REMOVE = JText::_('COM_LPS_TEMPLATES_CONFIRM_LAYOUT_REMOVE');
		$language->COM_LPS_FORMS_CONFIRM_REMOVE = JText::_('COM_LPS_FORMS_CONFIRM_REMOVE');
		$language->COM_LPS_FIELDS_CONFIRM_ORDERING_CHANGE = JText::_('COM_LPS_FIELDS_CONFIRM_ORDERING_CHANGE');
		$language->COM_LPS_FIELDS_CONFIRM_REMOVE = JText::_('COM_LPS_FIELDS_CONFIRM_REMOVE');
		$language->COM_LPS_SUBMISSION_CONFIRM_LEAD_CONVERSION = JText::_('COM_LPS_SUBMISSION_CONFIRM_LEAD_CONVERSION');
		$language->COM_LPS_SUBMISSION_EMAIL_LEAD_DETECT = JText::_('COM_LPS_SUBMISSION_EMAIL_LEAD_DETECT');
		$language->COM_LPS_SUBMISSION_EMAIL_ALREADY_LEAD = JText::_('COM_LPS_SUBMISSION_EMAIL_ALREADY_LEAD');
		$language->COM_LPS_SUBMISSION_CLICK_HERE_TO_ADD_LEAD = JText::_('COM_LPS_SUBMISSION_CLICK_HERE_TO_ADD_LEAD');
		$language->COM_LPS_SUBMISSION_ADD_LEAD = JText::_('COM_LPS_SUBMISSION_ADD_LEAD');

		return json_encode($language);
	}

    /**
    * return the html and javascript needed for pagination
    * @param $total (int) - total number of list items
    * @param $limit (int) - number of items to display
    * @param $limitstart (int) - starting limit
    * @return $html (string) - UI markup needed to render current state of pagination
    */
	public static function getPaginationPages($total,$limit,$limitstart) {
    	$quotient = $total / $limit;
    	$endpage = $quotient - 1;
    	$nextpage = $limitstart + $limit;
		$lastpage = $limitstart - $limit;
		if($lastpage < 0){$lastpage=0;} //make sure last page can't be negative
		//only show previous if we're not on the first page
		if ($limitstart > 0) {
			$html .= '<li><a class="previous" onclick="initPagination('.$lastpage.');" href="javascript:void(0);" ><i class="uk-icon-angle-double-left"></i></a></li>';
		}
		$c=1;
		for($i=0; $i<=$total; $i=$i+$limit){ //count by whatever the limit is set to be 10, 20, 30 etc
			if ($c <= 10) {
    			if ($i == $limitstart || (($limitstart == 0) && ($c == 1)) ) {
    				$html .= '<li class="uk-active"><span>'.$c.'</span></li>';
    				//$nextpage = $limitstart + $limit;
    			/*} elseif ($limitstart == 0) {
    				$html .= '<strong>'.$c.'</strong>';
    				$nextpage = $limitstart + $limit;*/
    			} else {
    				$html .= '<li><a onclick="initPagination('.$i.');" id="limitstart_'.$i.'" href="javascript:void(0);" title="'.$c.'">'.$c.'</a></li>';
    				//$nextpage = $limitstart + $limit;
    			}
			} else {
    			if ($i == $limitstart || (($limitstart == 0) && ($c == 1)) ) {
    				$html .= '<li class="uk-active"><span>'.$c.'</span></li>';
    				//$nextpage = $limitstart + $limit;
    			/*} elseif ($limitstart == 0) {
    				$html .= '<strong>'.$c.'</strong>';
    				$nextpage = $limitstart + $limit;*/
    			} else {
    				$html .= '<li><a style="display:none;" onclick="initPagination('.$i.');" id="limitstart_'.$i.'" href="javascript:void(0);" title="'.$c.'">'.$c.'</a></li>';
    				//$nextpage = $limitstart + $limit;
    			}

    			/*if ($i == $limitstart) {
    				$html .= '<li class="uk-active"><span>'.$c.'</span></li>';
    				//$nextpage = $limitstart + $limit;
    			} elseif ($limitstart == 0) {
    				$html .= '<li class="uk-active"><span>'.$c.'</span></li>';
    				//$nextpage = $limitstart + $limit;
    			} else {
    				$html .= '<li><a style="display:none;" onclick="initPagination('.$i.');" id="limitstart_'.$i.'" href="javascript:void(0);" title="'.$c.'">'.$c.'</a></li>';
    				//$nextpage = $limitstart + $limit;
    			}    	*/		
			}
			$c++;
      	}
      	//only show next if our limit+limitstart don't exceed the total amount of items
      	if ( ($limitstart + $limit) < $total ) {
      		$html .= '<li><a class="next" onclick="initPagination('.$nextpage.');" href="javascript:void(0);" ><i class="uk-icon-angle-double-right"></i></a></li>';
      	}
    	

    	return $html;
	}

}
