<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

// no direct access
defined('_JEXEC') or die; ?>

<hr />

<h3><?php echo JText::_('COM_LPS_NEW_TEXTBOX_FORM_HEADING'); ?></h3>

<ul class="uk-tab" data-uk-tab>
    <li class="uk-active" id="textbox-general-btn"><a href="javascript:void(0);" onclick="showFormFieldGeneralArea('textbox')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_GENERAL'); ?></a></li>
    <li id="textbox-validation-btn"><a href="javascript:void(0);" onclick="showFormFieldValidationArea('textbox')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_VALIDATIONS'); ?></a></li>
    <li id="textbox-attributes-btn"><a href="javascript:void(0);" onclick="showFormFieldAttributesArea('textbox')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_ATTRIBUTES'); ?></a></li>
</ul>
<div style="height:15px;"></div>

<div id="textbox-general">

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_( 'COM_LPS_NAME_FIELD_NAME' ); ?>
        </label>
        <div class="uk-form-controls">
            <input name="lps-fields-textbox-name" id="lps-fields-textbox-name" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_NAME_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
            <div id="lps-fields-textbox-name-validation-msg" style="display:none;color:#D85030;"></div>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-controls">
        <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_( 'COM_LPS_PUBLISHED_FIELD_NAME' ); ?></span> <i id="art-calendar-published" onclick="toggleIcon(0,'published','art-calendar-published')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
    </div>
 
    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_SELECT_FORM_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <select name="lps-fields-textbox-form-id" id="lps-fields-textbox-form-id">
                <option value=""><?php echo JText::_('COM_LPS_SELECT'); ?></option>
                <?php 
                    //populate forms for parent selection
                    if (count($this->forms) > 0) {
                        foreach($this->forms as $form) {
                            echo '<option value="'.$form->id.'">'.$form->name.'</option>';
                        }
                    }
                ?>
            </select>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_CAPTION_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <input name="lps-fields-textbox-caption" id="lps-fields-textbox-caption" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_CAPTION_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
            <div id="lps-fields-textbox-caption-validation-msg" style="display:none;color:#D85030;"></div>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_DEFAULT_VALUE_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <input name="lps-fields-textbox-default-value" id="lps-fields-textbox-default-value" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_DEFAULT_VALUE_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_DESCRIPTION_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
        	<textarea id="lps-fields-textbox-description" name="lps-fields-textbox-description" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_('COM_LPS_DESCRIPTION_FIELD_TOOLTIP'); ?>"></textarea>
        </div>
    </div>

</div>
<div id="textbox-validation" style="display:none;">

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
           <?php echo JText::_('COM_LPS_REQUIRED_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
        	<select name="lps-fields-textbox-required" id="lps-fields-textbox-required" data-uk-tooltip title="<?php echo JText::_('COM_LPS_REQUIRED_FIELD_TOOLTIP'); ?>">
                <option selected="selected" value="NO"><?php echo JText::_('COM_LPS_NO_OPTION'); ?></option>
                <option value="YES"><?php echo JText::_('COM_LPS_YES_OPTION'); ?></option>
            </select>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_VALIDATION_RULE_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
        	<select name="lps-fields-textbox-validation-rule" id="lps-fields-textbox-validation-rule" data-uk-tooltip title="<?php echo JText::_('COM_LPS_VALIDATION_RULE_FIELD_TOOLTIP'); ?>">
                <option selected="selected" value="none"><?php echo JText::_('COM_LPS_SELECT'); ?></option>
                <option value="alpha"><?php echo JText::_('COM_LPS_FIELDS_VALIDATION_ALPHA'); ?></option>
                <option value="numeric"><?php echo JText::_('COM_LPS_FIELDS_VALIDATION_NUMERIC'); ?></option>
                <option value="alphanumeric"><?php echo JText::_('COM_LPS_FIELDS_VALIDATION_ALPHANUMERIC'); ?></option>
                <option value="email"><?php echo JText::_('COM_LPS_FIELDS_VALIDATION_EMAIL'); ?></option>
                <option value="phonenumber"><?php echo JText::_('COM_LPS_FIELDS_VALIDATION_PHONE'); ?></option><!--(123-456-7890)-->
                <option value="ipaddress"><?php echo JText::_('COM_LPS_FIELDS_VALIDATION_IPADDRESS'); ?></option>
                <option value="validurl"><?php echo JText::_('COM_LPS_FIELDS_VALIDATION_URL'); ?></option><!--(http(s):// required)-->
            </select>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_VALIDATION_MESSAGE_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
        	<textarea id="lps-fields-textbox-validation-message" name="lps-fields-textbox-validation-message" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_('COM_LPS_VALIDATION_MESSAGE_FIELD_TOOLTIP'); ?>"><?php echo JText::_('COM_LPS_INVALID_INPUT'); ?></textarea>
        </div>
    </div>					        							        

</div>
<div id="textbox-attributes" style="display:none;">

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_SIZE_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
        	<input id="lps-fields-textbox-size" name="lps-fields-textbox-size" value="20" type="text" data-uk-tooltip title="<?php echo JText::_('COM_LPS_SIZE_FIELD_TOOLTIP'); ?>">
        </div>
    </div>	

	<div style="height:15px;"></div>    

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_MAX_SIZE_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
        	<input id="lps-fields-textbox-max-size" name="lps-fields-textbox-max-size" value="" type="text" data-uk-tooltip title="<?php echo JText::_('COM_LPS_MAX_SIZE_FIELD_TOOLTIP'); ?>">
        </div>
    </div>	

</div>
