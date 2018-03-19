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

<h3><?php echo JText::_('COM_LPS_NEW_CHECKBOX_GROUP_FORM_HEADING'); ?></h3>

<ul class="uk-tab" data-uk-tab>
    <li class="uk-active" id="checkboxgroup-general-btn"><a href="javascript:void(0);" onclick="showFormFieldGeneralArea('checkboxgroup')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_GENERAL'); ?></a></li>
    <li id="checkboxgroup-validation-btn"><a href="javascript:void(0);" onclick="showFormFieldValidationArea('checkboxgroup')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_VALIDATIONS'); ?></a></li>
    <li id="checkboxgroup-attributes-btn"><a href="javascript:void(0);" onclick="showFormFieldAttributesArea('checkboxgroup')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_ATTRIBUTES'); ?></a></li>
</ul>
<div style="height:15px;"></div>

<div id="checkboxgroup-general">

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_( 'COM_LPS_NAME_FIELD_NAME' ); ?>
        </label>
        <div class="uk-form-controls">
            <input name="lps-fields-checkboxgroup-name" id="lps-fields-checkboxgroup-name" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_NAME_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
            <div id="lps-fields-checkboxgroup-name-validation-msg" style="display:none;color:#D85030;"></div>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-controls">
        <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_( 'COM_LPS_PUBLISHED_FIELD_NAME' ); ?></span> <i id="lps-fields-checkboxgroup-published" onclick="toggleIcon(0,'published','lps-fields-checkboxgroup-published')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
    </div>
 
    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_SELECT_FORM_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <select name="lps-fields-checkboxgroup-form-id" id="lps-fields-checkboxgroup-form-id">
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
            <input name="lps-fields-checkboxgroup-caption" id="lps-fields-checkboxgroup-caption" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_CAPTION_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
            <div id="lps-fields-checkboxgroup-caption-validation-msg" style="display:none;color:#D85030;"></div>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_ITEMS_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <textarea id="lps-fields-checkboxgroup-items" name="lps-fields-checkboxgroup-items" rows="5" cols="20" data-uk-tooltip title="<?php echo JText::_('COM_LPS_ITEMS_FIELD_TOOLTIP'); ?>"></textarea>
            <div id="lps-fields-checkboxgroup-items-validation-msg" style="display:none;color:#D85030;"></div>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_DESCRIPTION_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
        	<textarea id="lps-fields-checkboxgroup-description" name="lps-fields-checkboxgroup-description" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_('COM_LPS_DESCRIPTION_FIELD_TOOLTIP'); ?>"></textarea>
        </div>
    </div>

</div>
<div id="checkboxgroup-validation" style="display:none;">
    <div class="uk-form-row">
        <label class="uk-form-label" for="">
           <?php echo JText::_('COM_LPS_REQUIRED_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <select name="lps-fields-checkboxgroup-required" id="lps-fields-checkboxgroup-required" data-uk-tooltip title="<?php echo JText::_('COM_LPS_REQUIRED_FIELD_TOOLTIP'); ?>">
                <option selected="selected" value="NO"><?php echo JText::_('COM_LPS_NO_OPTION'); ?></option>
                <option value="YES"><?php echo JText::_('COM_LPS_YES_OPTION'); ?></option>
            </select>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_VALIDATION_MESSAGE_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <textarea id="lps-fields-checkboxgroup-validation-message" name="lps-fields-checkboxgroup-validation-message" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_('COM_LPS_VALIDATION_MESSAGE_FIELD_TOOLTIP'); ?>"><?php echo JText::_('COM_LPS_INVALID_INPUT'); ?></textarea>
        </div>
    </div>  
</div>
<div id="checkboxgroup-attributes" style="display:none;">
    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_FLOW_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <select name="lps-fields-checkboxgroup-flow" id="lps-fields-checkboxgroup-flow" data-uk-tooltip title="<?php echo JText::_('COM_LPS_FLOW_FIELD_TOOLTIP'); ?>">
                <option value="HORIZONTAL">Horizontal<?php echo JText::_('COM_LPS_HORIZONTAL_OPTION'); ?></option>
                <option value="VERTICAL">Vertical<?php echo JText::_('COM_LPS_VERTICAL_OPTION'); ?></option>
            </select>
        </div>
    </div>
</div>

<div style="height:15px;"></div>








