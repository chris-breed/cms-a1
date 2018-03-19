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

<h3><?php echo JText::_('COM_LPS_EDIT_TEXTAREA_FORM_HEADING'); ?></h3>

<ul class="uk-tab" data-uk-tab>
    <li class="uk-active"><a href="javascript:void(0);" onclick="showEditFormFieldGeneralArea('textarea')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_GENERAL'); ?></a></li>
    <li><a href="javascript:void(0);" onclick="showEditFormFieldValidationArea('textarea')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_VALIDATIONS'); ?></a></li>
    <li><a href="javascript:void(0);" onclick="showEditFormFieldAttributesArea('textarea')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_ATTRIBUTES'); ?></a></li>
</ul>
<div style="height:15px;"></div>

<div id="textarea-edit-general">

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_( 'COM_LPS_NAME_FIELD_NAME' ); ?>
        </label>
        <div class="uk-form-controls">
            <input name="lps-fields-edit-textarea-name" id="lps-fields-edit-textarea-name" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_NAME_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-controls">
        <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_( 'COM_LPS_PUBLISHED_FIELD_NAME' ); ?></span> <i id="lps-fields-edit-textarea-published" onclick="toggleEditIcon(0,'published','lps-fields-edit-textarea-published')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
    </div>
 
    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_SELECT_FORM_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <select name="lps-fields-edit-textarea-form-id" id="lps-fields-edit-textarea-form-id">
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
            <input name="lps-fields-edit-textarea-caption" id="lps-fields-edit-textarea-caption" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_CAPTION_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_DEFAULT_VALUE_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <input name="lps-fields-edit-textarea-default-value" id="lps-fields-edit-textarea-default-value" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_DEFAULT_VALUE_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_DESCRIPTION_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
        	<textarea id="lps-fields-edit-textarea-description" name="lps-fields-edit-textarea-description" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_('COM_LPS_DESCRIPTION_FIELD_TOOLTIP'); ?>"></textarea>
        </div>
    </div>

</div>
<div id="textarea-edit-validation" style="display:none;">
    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_REQUIRED_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <select name="lps-fields-edit-textarea-required" id="lps-fields-edit-textarea-required" data-uk-tooltip title="<?php echo JText::_('COM_LPS_REQUIRED_FIELD_TOOLTIP'); ?>">
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
            <select name="lps-fields-edit-textarea-validation-rule" id="lps-fields-edit-textarea-validation-rule" data-uk-tooltip title="<?php echo JText::_('COM_LPS_VALIDATION_RULE_FIELD_TOOLTIP'); ?>">
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
            <textarea id="lps-fields-edit-textarea-validation-message" name="lps-fields-edit-textarea-validation-message" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_('COM_LPS_VALIDATION_MESSAGE_FIELD_TOOLTIP'); ?>"><?php echo JText::_('COM_LPS_INVALID_INPUT'); ?></textarea>
        </div>
    </div>  
</div>
<div id="textarea-edit-attributes" style="display:none;">
    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_SIZE_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <input id="lps-fields-edit-textarea-size" name="lps-fields-edit-textarea-size" value="20" type="text" data-uk-tooltip title="<?php echo JText::_('COM_LPS_SIZE_FIELD_TOOLTIP'); ?>">
        </div>
    </div>  

    <div style="height:15px;"></div>    

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_MAX_SIZE_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <input id="lps-fields-edit-textarea-max-size" name="lps-fields-edit-textarea-max-size" value="" type="text" data-uk-tooltip title="<?php echo JText::_('COM_LPS_MAX_SIZE_FIELD_TOOLTIP'); ?>">
        </div>
    </div>  
</div>

<div style="height:15px;"></div>








