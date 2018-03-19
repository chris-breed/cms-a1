<?php
/**
 * @version     1.1
 * @package     mod_lpsform - Display LPs Forms via module - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

//no direct access to this script
defined('_JEXEC') or die('Get thee gone!'); 


class modLpsFormHelper {

	public static function generateFormAction() {
		$jinput = JFactory::getApplication()->input;
		//generate appropriate url for form action
		$option = $jinput->getString('option', '');
		$view = $jinput->getString('view', ''); 
		$layout = $jinput->getString('layout', ''); 
		$itemId = $jinput->getInt('Itemid', ''); 

		$formActionUrl = 'index.php';
		if ($option) {
		    $formActionUrl .= '?option='.$option;
			if ($view) {
			    $formActionUrl .= '&view='.$view;
			}
			if ($layout) {
			    $formActionUrl .= '&layout='.$layout;
			}
		}
		if ($itemId) {
		    $formActionUrl .= '&Itemid='.$itemId;
		}		

		return $formActionUrl;
	}

    public static  function getForm($formId) {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_forms` WHERE `id`=".$formId;
        $db->setQuery($sql);
        $form = $db->loadObject();
        $form->fields = self::getFields($formId);

        return $form;
    }

    public static function getFields($formId) {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_fields` WHERE `form_id`=".$formId." ORDER BY `order` ASC";
        $db->setQuery($sql);
        if ($fields = $db->loadObjectList()) {
            $fieldContainer = array();
            foreach ($fields as $field) {
                $field->properties = self::getFieldProperties($field->id);
                $fieldContainer[] = $field;
            }
            return $fieldContainer;
        } else {
            return array();
        }
    }

    public static function getFieldProperties($fieldId) {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_field_properties` WHERE `field_id`=".$fieldId;
        $db->setQuery($sql);
        if ($properties = $db->loadObjectList()) {
            $propertyContainer = array();
            foreach ($properties as $property) {
                $propertyContainer[$property->property_name] = $property->property_value;
            }
            return $propertyContainer;
        } else {
            return array();
        }
    }

    public static function getFormValidations($formId) {
        $fields = self::getFields($formId);
        $db = JFactory::getDBO();
        $sql = "SELECT fp.field_id AS field_id, 
                       f.type_id AS type_id,
                       fp.property_name AS property_name, 
                       fp.property_value AS property_value
                FROM `#__lps_fields` AS f
                LEFT JOIN `#__lps_field_properties` AS fp ON fp.field_id=f.id
                WHERE fp.property_name='REQUIRED' 
                OR fp.property_name='VALIDATION_RULE' 
                OR fp.property_name='VALIDATION_MESSAGE'
                OR fp.property_name='NAME'
                OR fp.property_name='ITEMS'
                AND f.type_id !=10 
                AND f.type_id !=11";
        $db->setQuery($sql);
        $validations = $db->loadObjectList();
        if ( (count($validations) > 0) && (count($fields) > 0) ) {
            return self::assembleValidationStructure($fields,$validations);
        } else {
            return array();
        }
    }

    public static function assembleValidationStructure($fields,$validations) {
        $structure = array();
        foreach ($fields as $field) {
            $structure[] = self::getFieldValidations($field->id,$validations);
        }

        return $structure;
    }

    public static function getFieldValidations($fieldId,$validations) {
        $typeId = 0;
        $fieldValidations = new stdClass;
        $fieldValidations->field_id = $fieldId;
        //$fieldValidations->validations = array();
        foreach ($validations as $validation) {
            if ($validation->field_id == $fieldId) {
                $typeId = $validation->type_id;
                $propertyName = $validation->property_name;
                $propertyValue = $validation->property_value;
                $fieldValidations->$propertyName = $propertyValue;
            }
        }
        $fieldValidations->type_id = $typeId;

        return $fieldValidations;
    }

    public static function getFieldName($properties) {
        if (count($properties) > 0) {
            foreach ($properties as $key => $property) {
                if ($key == 'NAME') {
                    return $property;
                }
            }
        }

        return false;
    }

    public static function getFormHtml($form,$params) {
        $app = JFactory::getApplication();
        $html = '';

        //set the form container
        if ($params->get('lps_form_container','default') == "box") {
            $html .= '<div class="uk-panel uk-panel-box">';
        } elseif ($params->get('lps_form_container','default') == "box primary") {
            $html .= '<div class="uk-panel uk-panel-box uk-panel-box-primary">';
        } else {
            $html .= '<div class="uk-panel">';
        }
        
        $html .= '<form class="uk-form uk-form-stacked" method="post" action="'.self::generateFormAction().'" name="lps-form-'.$form->id.'" id="lps-form-'.$form->id.'">';
        
        if ($params->get('lps_show_form_title',0) == 1) {
            $html .= '<h2>'.$form->name.'</h2>';
        }

        if (count($form->fields) > 0) {
            foreach ($form->fields as $field) {

                $html .= '<div class="uk-form-row">';

                    if ($params->get('lps_field_labeling','label') == 'label') {
                        if (!in_array($field->type_id,array(11))) {
                            $html .= '<label class="uk-form-label">'.self::getFieldName($field->properties).'</label>';
                        }
                    } else {
                        if (!in_array($field->type_id,array(1,2,11))) {
                            $html .= '<label class="uk-form-label">'.self::getFieldName($field->properties).'</label>';
                        }
                    }

                    $html .= '<div class="uk-form-controls">'.self::getFrontFieldBody($form->id,$field->id,$field->type_id,$field->properties,$params).'</div>';
                $html .= '</div>';

            }
        }

        //$html .= '<input type="hidden" name="lps-view" id="lps-view-value" value="'.$app->input->getString('view','landingpages').'" />';
        $html .= '<input type="hidden" name="lps-form-id" id="lps-form-id-value" value="'.$form->id.'" />';
        $html .= '<input type="hidden" name="lps-id" id="lps-id-value" value="'.$app->input->getString('id',0).'" />';

        $html .= '</form>';
        $html .= '</div>';

        return $html;
    }

    public static function getFrontFieldBody($formId, $fieldId, $typeId, $data, $params) {   
        $out = '';
        
        switch($typeId)
        {
            case 1:
            case 'text_box':
                if (array_key_exists('VALIDATIONRULE',$data) && $data['VALIDATIONRULE'] == 'password') {
                    $defaultValue = '';
                } else {
                    if (array_key_exists('DEFAULTVALUE',$data)) {
                        $defaultValue = $data['DEFAULTVALUE'];
                    } else {
                        $defaultValue = '';
                    }
                }
                
                $className = array();
                if ($params->get('lps_field_size','default') == 'small') {
                    $className[] = 'uk-form-small';
                } elseif ($params->get('lps_field_size','default') == 'large') {
                    $className[] = 'uk-form-large';
                }
                if ($params->get('lps_field_width','default') == '25') {
                    $className[] = 'uk-width-1-4';
                } elseif ($params->get('lps_field_width','default') == '33') {
                    $className[] = 'uk-width-1-3';
                } elseif ($params->get('lps_field_width','default') == '50') {
                    $className[] = 'uk-width-1-2';
                } elseif ($params->get('lps_field_width','default') == '100') {
                    $className[] = 'uk-width-1-1';
                }
                if ($params->get('lps_field_labeling','label') == 'placeholder') {
                    $placeholder = 'placeholder="'.$data['NAME'].'"';
                } else {
                    $placeholder = '';
                }
                if (count($className) > 0) {
                    $classTxt = 'class="'.implode(' ',$className).'"';
                } else {
                    $classTxt = '';
                }

                $fieldName = self::getFieldPostName($data['NAME'],$fieldId);

                $out .= '<input '.$classTxt.' '.$placeholder.' type="text" value="'.self::htmlEscape($defaultValue).'" name="'.$fieldName.'" id="'.$fieldName.'" />';
                $out .= '<div id="'.$fieldName.'_error_msg" style="display:none;margin-left:5px;color:#D85030;"></div>';
            break;

            case 2:
            case 'text_area':
                if (array_key_exists('DEFAULTVALUE',$data)) {
                    $defaultValue = $data['DEFAULTVALUE'];
                } else {
                    $defaultValue = '';
                }
                
                $className = array();
                if ($params->get('lps_field_size','default') == 'small') {
                    $className[] = 'uk-form-small';
                } elseif ($params->get('lps_field_size','default') == 'large') {
                    $className[] = 'uk-form-large';
                }
                if ($params->get('lps_field_width','default') == '25') {
                    $className[] = 'uk-width-1-4';
                } elseif ($params->get('lps_field_width','default') == '33') {
                    $className[] = 'uk-width-1-3';
                } elseif ($params->get('lps_field_width','default') == '50') {
                    $className[] = 'uk-width-1-2';
                } elseif ($params->get('lps_field_width','default') == '100') {
                    $className[] = 'uk-width-1-1';
                }
                if ($params->get('lps_field_labeling','label') == 'placeholder') {
                    $placeholder = 'placeholder="'.$data['NAME'].'"';
                } else {
                    $placeholder = '';
                }
                if (count($className) > 0) {
                    $classTxt = 'class="'.implode(' ',$className).'"';
                } else {
                    $classTxt = '';
                }
                $fieldName = self::getFieldPostName($data['NAME'],$fieldId);
                if (array_key_exists('COLS',$data)) {
                    $cols = $data['COLS'];
                } else {
                    $cols = '';
                }
                if (array_key_exists('ROWS',$data)) {
                    $rows = $data['ROWS'];
                } else {
                    $rows = '';
                }
                $out .= '<textarea '.$classTxt.' '.$placeholder.' cols="'.$cols.'" rows="'.$rows.'" name="'.$fieldName.'" id="'.$fieldName.'" >'.self::htmlEscape($defaultValue).'</textarea>';
                $out .= '<div id="'.$fieldName.'_error_msg" style="display:none;margin-left:5px;color:#D85030;"></div>';
            break;

            case 3:
            case 'select_list':
                $className = array();
                if ($params->get('lps_field_size','default') == 'small') {
                    $className[] = 'uk-form-small';
                } elseif ($params->get('lps_field_size','default') == 'large') {
                    $className[] = 'uk-form-large';
                }
                if ($params->get('lps_field_width','default') == '25') {
                    $className[] = 'uk-width-1-4';
                } elseif ($params->get('lps_field_width','default') == '33') {
                    $className[] = 'uk-width-1-3';
                } elseif ($params->get('lps_field_width','default') == '50') {
                    $className[] = 'uk-width-1-2';
                } elseif ($params->get('lps_field_width','default') == '100') {
                    $className[] = 'uk-width-1-1';
                }
                if (count($className) > 0) {
                    $classTxt = 'class="'.implode(' ',$className).'"';
                } else {
                    $classTxt = '';
                }
                
                $fieldName = self::getFieldPostName($data['NAME'],$fieldId);
                $out .= '<select '.$classTxt.' name="'.$fieldName.'" id="'.$fieldName.'" >';
                
                $items = self::explode(self::isCode($data['ITEMS']));
                
                $special = array('[c]', '[g]', '[d]');
                
                foreach ($items as $item)
                {
                    @list($val, $txt) = @explode('|', str_replace($special, '', $item), 2);
                    if (is_null($txt))
                        $txt = $val;
                    
                    // <optgroup>
                    if (strpos($item, '[g]') !== false) {
                        $out .= '<optgroup label="'.self::htmlEscape($val).'">';
                        continue;
                    }
                    // </optgroup>
                    if(strpos($item, '[/g]') !== false) {
                        $out .= '</optgroup>';
                        continue;
                    }
                    
                    $additional = '';
                    // selected
                    //commented out because of in_array error
                    //if ((strpos($item, '[c]') !== false && empty($value)) || (isset($value[$data['NAME']]) && in_array($val, $value[$data['NAME']])))
                        //$additional .= 'selected="selected"';
                    // disabled
                    //if (strpos($item, '[d]') !== false)
                        //$additional .= 'disabled="disabled"';
                    
                    $out .= '<option '.$additional.' value="'.self::htmlEscape($val).'">'.self::htmlEscape($txt).'</option>';
                }
                $out .= '</select>';
                $out .= '<div id="'.$fieldName.'_error_msg" style="display:none;margin-left:5px;color:#D85030;"></div>';
                
            break;
            
            case 4:
            case 'checkbox_group':
                $i = 0;
                
                $items = self::explode(self::isCode($data['ITEMS']));
                
                $special = array('[c]', '[d]');
                
                foreach ($items as $item)
                {
                    @list($val, $txt) = @explode('|', str_replace($special, '', $item), 2);
                    if (is_null($txt))
                        $txt = $val;
                    
                    $additional = '';

                    if (strpos($item, '[d]') !== false)
                        $additional .= 'disabled="disabled"';
                    
                    if ($data['FLOW']=='VERTICAL') {
                        $out .= '<p class="lps-vertical-clear">';
                    }

                    $fieldName = self::getFieldPostName($data['NAME'],$fieldId);
                    $out .= '<input '.$additional.' name="'.$fieldName.'" type="checkbox" value="'.self::htmlEscape($val).'" id="'.$fieldName.'__'.$i.'" /><label for="'.$fieldName.'__'.$i.'">'.$txt.'</label>';
                    
                    if ($data['FLOW']=='VERTICAL') {
                        $out .= '</p>';
                    }   
                    $i++;
                }
                $out .= '<div id="'.$fieldName.'_error_msg" style="display:none;margin-left:5px;color:#D85030;"></div>';
            break;
            
            case 5:
            case 'radio_group':
                $i = 0;
                
                $items = self::explode(self::isCode($data['ITEMS']));
                
                $special = array('[c]', '[d]');
                
                foreach ($items as $item)
                {
                    @list($val, $txt) = @explode('|', str_replace($special, '', $item), 2);
                    if (is_null($txt))
                        $txt = $val;
                        
                    $additional = '';
                    // checked
                    if ((strpos($item, '[c]') !== false && empty($value)) || (isset($value[$data['NAME']]) && $val == $value[$data['NAME']])) {
                        $additional .= 'checked="checked"';
                    }
                        
                    // disabled
                    if (strpos($item, '[d]') !== false) {
                        $additional .= 'disabled="disabled"';
                    }
                    
                    if ($data['FLOW']=='VERTICAL') {
                        $out .= '<p>';
                    }
                    
                    $fieldName = self::getFieldPostName($data['NAME'],$fieldId);
                    $out .= '<input '.$additional.' name="'.$fieldName.'" type="radio" value="'.self::htmlEscape($val).'" id="'.$fieldName.'__'.$i.'" /><label for="'.$fieldName.'__'.$i.'">'.$txt.'</label>';
                    if ($data['FLOW']=='VERTICAL') {
                        $out .= '</p>';
                    }

                    $i++;
                }
                $out .= '<div id="'.$fieldName.'_error_msg" style="display:none;margin-left:5px;color:#D85030;"></div>';
            break;
            
            case 6:
            case 'calendar':
                $calendars = self::componentExists($formId, 6);
                $calendars = array_flip($calendars);

                $defaultValue = (!array_key_exists('DEFAULTVALUE',$data)) ? '' : $data['DEFAULTVALUE'];

                $datePickerOptions = array();
                
                if (array_key_exists('DATEFORMAT',$data)) {
                    if ($data['DATEFORMAT'] == "") {
                        $datePickerOptions[] = 'dateFormat: "dd.mm.yy"';
                    } else {
                        $datePickerOptions[] = 'dateFormat: "'.$data['DATEFORMAT'].'"';
                    }
                } else {
                    $datePickerOptions[] = 'dateFormat: "dd.mm.yy"';
                }
                // minDate: new Date(2007, 1 - 1, 1), maxDate: new Date(2007, 1 - 1, 1)
                
                if (array_key_exists('MINDATE',$data)) {
                    $datePickerOptions[] = 'minDate: new Date("'.$data['MINDATE'].'")';
                }

                if (array_key_exists('MAXDATE',$data)) {
                    $datePickerOptions[] = 'maxDate: new Date("'.$data['MAXDATE'].'")';
                }

                $optionJson = '{'.implode(',',$datePickerOptions).'}';

                $out .= "<script type=\"text/javascript\" src=\"//code.jquery.com/ui/1.11.4/jquery-ui.js\"></script>";
                $out .= '<script type="text/javascript">jQuery(function($){ $( "#txtcal'.$formId.'_'.$calendars[$fieldId].'" ).datepicker('.$optionJson.'); });</script>';
                
                $fieldName = self::getFieldPostName($data['NAME'],$fieldId);
                $out .= '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">';
                $out .= '<input id="txtcal'.$formId.'_'.$calendars[$fieldId].'" name="'.$fieldName.'" type="text" class="txtCal '.$formId.'_'.$calendars[$fieldId].'" value="'.self::htmlEscape($defaultValue).'" /><br />';
                
                $out .= '<input id="hiddencal_'.$fieldName.'" type="hidden" name="hidden_'.$fieldName.'" />';
                $out .= '<div id="'.$fieldName.'_error_msg" style="display:none;margin-left:5px;color:#D85030;"></div>';
            break;
            
            case 10:
            case 'freeText':
                if (array_key_exists('TEXT',$data)) {
                    $out .= $data['TEXT'];
                }
                
            break;
            
            case 11:
            case 'submitButton':

                $className = 'lps-submit-button';
                $style = '';

                //if (array_key_exists('ICON',$data)) {
                    //$out .= '<button class="uk-button uk-button-primary" '.$style.' type="submit" name="form['.$data['NAME'].']" id="'.$data['NAME'].'" '.$data['ADDITIONALATTRIBUTES'].'><i class="uk-icon-'.$data['ICON'].'"></i> '.self::htmlEscape($data['LABEL']).'</button>';
                //} else {
                    $out .= '<a href="javascript:void(0);" class="uk-button uk-button-primary" '.$style.' onclick="submitLpsForm('.$formId.')" id="'.$data['NAME'].'" >'.self::htmlEscape($data['LABEL']).'</a>';
                //}

            break;
       
        }
        
        //Trigger Event - rsfp_bk_onAfterCreateFrontComponentBody
        //$mainframe->triggerEvent('submission_manager_bk_onAfterCreateFrontComponentBody',array(array('out'=>&$out, 'formId'=>$formId, 'componentId'=>$componentId,'data'=>$data,'value'=>$value,'r'=>$r, 'invalid' => $invalid)));
        return $out;
    }

    public static function htmlEscape($val) {
        return htmlentities($val, ENT_COMPAT, 'UTF-8');
    }

    public static function explode($value) {
        $value = str_replace(array("\r\n", "\r"), "\n", $value);
        $value = explode("\n", $value);
        
        return $value;
    }

    public static function isCode($value) {
        if (strpos($value, '<code>') !== false) {
            return eval($value);
        }
        
        return $value;
    }

    public static function componentExists($formId, $typeId) {
        $formId = (int) $formId;
        $db = JFactory::getDBO();
        
        if (is_array($typeId))
        {
            JArrayHelper::toInteger($typeId);
            $db->setQuery("SELECT `id` FROM `#__lps_fields` WHERE `type_id` IN (".implode(',', $componentTypeId).") AND form_id='".$formId."' AND published='1'");
        }
        else
        {
            $typeId = (int) $typeId;
            $db->setQuery("SELECT `id` FROM `#__lps_fields` WHERE `type_id`='".$typeId."' AND form_id='".$formId."' AND published='1'");
        }
        
        return $db->loadColumn();
    }

    public static function getFieldPostName($name,$fieldId) {
        $raw = strtolower(str_replace(' ','-',$name));
        return $raw.'__'.$fieldId;
    }

    public static function retrieveFormValues($form) {
        $input = JFactory::getApplication()->input;
        $view = $input->getString('lps-view');
        
        $fieldNames = self::getFormFieldNames($form);
        //var_dump($fieldNames);echo '<br />';
        $data = array();
        foreach($fieldNames as $fieldId => $name) {
            $data[$fieldId] = $input->getString(self::getFieldPostName($name,$fieldId));
        }
        return $data;
    }

    public static function getFormFieldNames($form) {
        if (count($form->fields) > 0) {
            $names = array();
            foreach($form->fields as $field) {
                //var_dump($field->properties);echo '<br />';
                $names[$field->id] = $field->properties['NAME'];
            }
            return $names;
        }
        return false;
    }

    public static function storeSubmission($formId) {
        $db = JFactory::getDBO();     
        $data = array();
        $data['form_id'] = $formId;
        $data['created'] = date('Y-m-d H:i:s');
        $data['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $data['user_id'] = JFactory::getUser()->id;

        $sql = "INSERT INTO `#__lps_submissions` (`form_id`,`created`,`user_ip`,`user_id`) VALUES
        		('".$data['form_id']."','".$data['created']."','".$data['user_ip']."','".$data['user_id']."')";
        $db->setQuery($sql);
        $db->execute();

        return $db->insertid();
    }

    public static function storeSubmissionValue($submissionId,$fieldId,$value) {
        $data = array();
        $db = JFactory::getDBO();     

        $data['submission_id'] = $submissionId;
        $data['field_id'] = $fieldId;
        $data['value'] = $value;

        $sql = "INSERT INTO `#__lps_submission_values` (`submission_id`,`field_id`,`value`) VALUES
        		('".$data['submission_id']."','".$data['field_id']."','".$data['value']."')";
        $db->setQuery($sql);
        $db->execute();
    }

	public static function processForm() {	
		$app = JFactory::getApplication();
		$formId = $app->input->getInt('lps-form-id');
		$form = self::getForm($formId);
		$data = self::retrieveFormValues($form);

		$submissionId = self::storeSubmission($formId);
		foreach($data as $fieldId => $value) {
			if (!empty($value)) {
				self::storeSubmissionValue($submissionId,$fieldId,$value);
			}
		}

		$msg = ($form->thank_you_message !="") ? $form->thank_you_message : 'Thank you for submitting.';

		if (strlen($form->return_url) > 4) {
			$app->redirect($form->return_url,$msg);
		} else {
			$app->redirect(self::generateFormAction(),$msg);
		}

	}

}
