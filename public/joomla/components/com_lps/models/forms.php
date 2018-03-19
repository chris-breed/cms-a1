<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting Landing Page Forms
 */
class LpsModelForms extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    public function getForm($formId) {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_forms` WHERE `id`=".$formId;
        $db->setQuery($sql);
        $form = $db->loadObject();
        $form->fields = $this->getFields($formId);

        return $form;
    }

    public function getFields($formId) {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_fields` WHERE `form_id`=".$formId." ORDER BY `order` ASC";
        $db->setQuery($sql);
        if ($fields = $db->loadObjectList()) {
            $fieldContainer = array();
            foreach ($fields as $field) {
                $field->properties = $this->getFieldProperties($field->id);
                $fieldContainer[] = $field;
            }
            return $fieldContainer;
        } else {
            return array();
        }
    }

    public function getFieldProperties($fieldId) {
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

    public function getFormValidations($formId) {
        $fields = $this->getFields($formId);
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
            return $this->assembleValidationStructure($fields,$validations);
        } else {
            return array();
        }
    }

    public function assembleValidationStructure($fields,$validations) {
        $structure = array();
        foreach ($fields as $field) {
            $structure[] = $this->getFieldValidations($field->id,$validations);
        }

        return $structure;
    }

    public function getFieldValidations($fieldId,$validations) {
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


    public function addFormToLandingPageContent($tmplHtml,$formHtml) {
        $regex = '/\{lpsformplaceholder((\s+[a-z\_0-9]+=(?:"[^"]*"|&quot;.*?&quot;|[^\s}]*))*\s*)\}(?:(.*?){\/lpsformplaceholder\})?/si';
        $lpContentHtml = preg_replace($regex,$formHtml,$tmplHtml);
        return $lpContentHtml;
    }

    public function getFieldName($properties) {
        if (count($properties) > 0) {
            foreach ($properties as $key => $property) {
                if ($key == 'NAME') {
                    return $property;
                }
            }
        }

        return false;
    }

    public function getFormHtml($template,$form) {
        $app = JFactory::getApplication();
        $html = '';

        //set the form container
        if ($template->form_container == "box") {
            $html .= '<div class="uk-panel uk-panel-box">';
        } elseif ($template->form_container == "box primary") {
            $html .= '<div class="uk-panel uk-panel-box uk-panel-box-primary">';
        } else {
            $html .= '<div class="uk-panel">';
        }
        
        $html .= '<form class="uk-form uk-form-stacked" method="post" action="index.php?option=com_lps&task=LandingPages.processForm" name="lps-form-'.$form->id.'" id="lps-form-'.$form->id.'">';
        
            if ($template->show_form_title == 1) {
                $html .= '<h2>'.$form->name.'</h2>';
            }

            if (count($form->fields) > 0) {
                foreach ($form->fields as $field) {

                    $html .= '<div class="uk-form-row">';

                        if ($template->field_labeling == 'label') {
                            if (!in_array($field->type_id,array(11))) {
                                $html .= '<label class="uk-form-label">'.$this->getFieldName($field->properties).'</label>';
                            }
                        } else {
                            if (!in_array($field->type_id,array(1,2,11))) {
                                $html .= '<label class="uk-form-label">'.$this->getFieldName($field->properties).'</label>';
                            }
                        }

                        $html .= '<div class="uk-form-controls">'.$this->getFrontFieldBody($form->id,$field->id,$field->type_id,$field->properties,$template).'</div>';
                    $html .= '</div>';

                }
            }

            $html .= '<input type="hidden" name="lps-view" id="lps-view-value" value="'.$app->input->getString('view','landingpages').'" />';
            $html .= '<input type="hidden" name="lps-form-id" id="lps-form-id-value" value="'.$form->id.'" />';
            $html .= '<input type="hidden" name="lps-id" id="lps-id-value" value="'.$app->input->getString('id',0).'" />';

        $html .= '</form>';
        $html .= '</div>';

        return $html;
    }

    public function getFrontFieldBody($formId, $fieldId, $typeId, $data, $template) {   
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
                if ($template->field_size == 'small') {
                    $className[] = 'uk-form-small';
                } elseif ($template->field_size == 'large') {
                    $className[] = 'uk-form-large';
                }
                if ($template->field_width == '25') {
                    $className[] = 'uk-width-1-4';
                } elseif ($template->field_width == '33') {
                    $className[] = 'uk-width-1-3';
                } elseif ($template->field_width == '50') {
                    $className[] = 'uk-width-1-2';
                } elseif ($template->field_width == '100') {
                    $className[] = 'uk-width-1-1';
                }
                if ($template->field_labeling == 'placeholder') {
                    $placeholder = 'placeholder="'.$data['NAME'].'"';
                } else {
                    $placeholder = '';
                }
                if (count($className) > 0) {
                    $classTxt = 'class="'.implode(' ',$className).'"';
                } else {
                    $classTxt = '';
                }

                $fieldName = $this->getFieldPostName($data['NAME'],$fieldId);

                $out .= '<input '.$classTxt.' '.$placeholder.' type="text" value="'.$this->htmlEscape($defaultValue).'" name="'.$fieldName.'" id="'.$fieldName.'" />';
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
                if ($template->field_size == 'small') {
                    $className[] = 'uk-form-small';
                } elseif ($template->field_size == 'large') {
                    $className[] = 'uk-form-large';
                }
                if ($template->field_width == '25') {
                    $className[] = 'uk-width-1-4';
                } elseif ($template->field_width == '33') {
                    $className[] = 'uk-width-1-3';
                } elseif ($template->field_width == '50') {
                    $className[] = 'uk-width-1-2';
                } elseif ($template->field_width == '100') {
                    $className[] = 'uk-width-1-1';
                }
                if ($template->field_labeling == 'placeholder') {
                    $placeholder = 'placeholder="'.$data['NAME'].'"';
                } else {
                    $placeholder = '';
                }
                if (count($className) > 0) {
                    $classTxt = 'class="'.implode(' ',$className).'"';
                } else {
                    $classTxt = '';
                }
                $fieldName = $this->getFieldPostName($data['NAME'],$fieldId);
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
                $out .= '<textarea '.$classTxt.' '.$placeholder.' cols="'.$cols.'" rows="'.$rows.'" name="'.$fieldName.'" id="'.$fieldName.'" >'.$this->htmlEscape($defaultValue).'</textarea>';
                $out .= '<div id="'.$fieldName.'_error_msg" style="display:none;margin-left:5px;color:#D85030;"></div>';
            break;

            case 3:
            case 'select_list':
                $className = array();
                if ($template->field_size == 'small') {
                    $className[] = 'uk-form-small';
                } elseif ($template->field_size == 'large') {
                    $className[] = 'uk-form-large';
                }
                if ($template->field_width == '25') {
                    $className[] = 'uk-width-1-4';
                } elseif ($template->field_width == '33') {
                    $className[] = 'uk-width-1-3';
                } elseif ($template->field_width == '50') {
                    $className[] = 'uk-width-1-2';
                } elseif ($template->field_width == '100') {
                    $className[] = 'uk-width-1-1';
                }
                if (count($className) > 0) {
                    $classTxt = 'class="'.implode(' ',$className).'"';
                } else {
                    $classTxt = '';
                }
                
                $fieldName = $this->getFieldPostName($data['NAME'],$fieldId);
                $out .= '<select '.$classTxt.' name="'.$fieldName.'" id="'.$fieldName.'" >';
                
                $items = $this->explode($this->isCode($data['ITEMS']));
                
                $special = array('[c]', '[g]', '[d]');
                
                foreach ($items as $item)
                {
                    @list($val, $txt) = @explode('|', str_replace($special, '', $item), 2);
                    if (is_null($txt))
                        $txt = $val;
                    
                    // <optgroup>
                    if (strpos($item, '[g]') !== false) {
                        $out .= '<optgroup label="'.$this->htmlEscape($val).'">';
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
                    
                    $out .= '<option '.$additional.' value="'.$this->htmlEscape($val).'">'.$this->htmlEscape($txt).'</option>';
                }
                $out .= '</select>';
                $out .= '<div id="'.$fieldName.'_error_msg" style="display:none;margin-left:5px;color:#D85030;"></div>';
                
            break;
            
            case 4:
            case 'checkbox_group':
                $i = 0;
                
                $items = $this->explode($this->isCode($data['ITEMS']));
                
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

                    $fieldName = $this->getFieldPostName($data['NAME'],$fieldId);
                    $out .= '<input '.$additional.' name="'.$fieldName.'" type="checkbox" value="'.$this->htmlEscape($val).'" id="'.$fieldName.'__'.$i.'" /><label for="'.$fieldName.'__'.$i.'">'.$txt.'</label>';
                    
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
                
                $items = $this->explode($this->isCode($data['ITEMS']));
                
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
                    
                    $fieldName = $this->getFieldPostName($data['NAME'],$fieldId);
                    $out .= '<input '.$additional.' name="'.$fieldName.'" type="radio" value="'.$this->htmlEscape($val).'" id="'.$fieldName.'__'.$i.'" /><label for="'.$fieldName.'__'.$i.'">'.$txt.'</label>';
                    if ($data['FLOW']=='VERTICAL') {
                        $out .= '</p>';
                    }

                    $i++;
                }
                $out .= '<div id="'.$fieldName.'_error_msg" style="display:none;margin-left:5px;color:#D85030;"></div>';
            break;
            
            case 6:
            case 'calendar':
                $calendars = $this->componentExists($formId, 6);
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

                $dom = JFactory::getDocument();
                $dom->addScriptDeclaration('jQuery(function($){ $( "#txtcal'.$formId.'_'.$calendars[$fieldId].'" ).datepicker('.$optionJson.'); });');
                
                $fieldName = $this->getFieldPostName($data['NAME'],$fieldId);
                $out .= '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">';
                $out .= '<input id="txtcal'.$formId.'_'.$calendars[$fieldId].'" name="'.$fieldName.'" type="text" class="txtCal '.$formId.'_'.$calendars[$fieldId].'" value="'.$this->htmlEscape($defaultValue).'" /><br />';
                
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
                    //$out .= '<button class="uk-button uk-button-primary" '.$style.' type="submit" name="form['.$data['NAME'].']" id="'.$data['NAME'].'" '.$data['ADDITIONALATTRIBUTES'].'><i class="uk-icon-'.$data['ICON'].'"></i> '.$this->htmlEscape($data['LABEL']).'</button>';
                //} else {
                    $out .= '<a href="javascript:void(0);" class="uk-button uk-button-primary" '.$style.' onclick="submitLpsForm('.$formId.')" id="'.$data['NAME'].'" >'.$this->htmlEscape($data['LABEL']).'</a>';
                //}

            break;
       
        }
        
        //Trigger Event - rsfp_bk_onAfterCreateFrontComponentBody
        //$mainframe->triggerEvent('submission_manager_bk_onAfterCreateFrontComponentBody',array(array('out'=>&$out, 'formId'=>$formId, 'componentId'=>$componentId,'data'=>$data,'value'=>$value,'r'=>$r, 'invalid' => $invalid)));
        return $out;
    }

    function htmlEscape($val) {
        return htmlentities($val, ENT_COMPAT, 'UTF-8');
    }

    function explode($value) {
        $value = str_replace(array("\r\n", "\r"), "\n", $value);
        $value = explode("\n", $value);
        
        return $value;
    }

    function isCode($value) {
        if (strpos($value, '<code>') !== false) {
            return eval($value);
        }
        
        return $value;
    }

    function componentExists($formId, $typeId) {
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

    public function getFieldPostName($name,$fieldId) {
        $raw = strtolower(str_replace(' ','-',$name));
        return $raw.'__'.$fieldId;
    }

    public function retrieveFormValues($form) {
        $input = JFactory::getApplication()->input;
        $view = $input->getString('lps-view');
        
        $fieldNames = $this->getFormFieldNames($form);
        //var_dump($fieldNames);echo '<br />';
        $data = array();
        foreach($fieldNames as $fieldId => $name) {
            $data[$fieldId] = $input->getString($this->getFieldPostName($name,$fieldId));
        }
        return $data;
    }

    public function getFormFieldNames($form) {
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

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {

        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $this->setState('list.limit', $limit);

        $limitstart = JFactory::getApplication()->input->getInt('limitstart', 0);
        $this->setState('list.start', $limitstart);

    		if(empty($ordering)) {
    			$ordering = 'a.ordering';
    		}

        // List state information.
        parent::populateState($ordering, $direction);
    }

}
