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

<h3><?php echo JText::_('COM_LPS_NEW_CALENDAR_FORM_HEADING'); ?></h3>

<ul class="uk-tab" data-uk-tab>
    <li class="uk-active" id="calendar-general-btn"><a href="javascript:void(0);" onclick="showFormFieldGeneralArea('calendar')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_GENERAL'); ?></a></li>
    <li id="calendar-validation-btn"><a href="javascript:void(0);" onclick="showFormFieldValidationArea('calendar')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_VALIDATIONS'); ?></a></li>
    <li id="calendar-attributes-btn"><a href="javascript:void(0);" onclick="showFormFieldAttributesArea('calendar')" class="element-subnav"><?php echo JText::_('COM_LPS_FIELDS_ATTRIBUTES'); ?></a></li>
</ul>
<div style="height:15px;"></div>

<div id="calendar-general">

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_( 'COM_LPS_NAME_FIELD_NAME' ); ?>
        </label>
        <div class="uk-form-controls">
            <input name="lps-fields-calendar-name" id="lps-fields-calendar-name" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_NAME_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
            <div id="lps-fields-calendar-name-validation-msg" style="display:none;color:#D85030;"></div>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-controls">
        <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_( 'COM_LPS_PUBLISHED_FIELD_NAME' ); ?></span> <i id="lps-fields-calendar-published" onclick="toggleIcon(0,'published','lps-fields-calendar-published')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
    </div>
 
    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_SELECT_FORM_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <select name="lps-fields-calendar-form-id" id="lps-fields-calendar-form-id">
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
            <input name="lps-fields-calendar-caption" id="lps-fields-calendar-caption" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_CAPTION_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
            <div id="lps-fields-calendar-caption-validation-msg" style="display:none;color:#D85030;"></div>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_DEFAULT_VALUE_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <input name="lps-fields-calendar-default-value" id="lps-fields-calendar-default-value" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_DEFAULT_VALUE_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_DESCRIPTION_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
        	<textarea id="lps-fields-calendar-description" name="lps-fields-calendar-description" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_('COM_LPS_DESCRIPTION_FIELD_TOOLTIP'); ?>"></textarea>
        </div>
    </div>

</div>
<div id="calendar-validation" style="display:none;">
    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_REQUIRED_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <select name="lps-fields-calendar-required" id="lps-fields-calendar-required" data-uk-tooltip title="<?php echo JText::_('COM_LPS_REQUIRED_FIELD_TOOLTIP'); ?>">
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
            <textarea id="lps-fields-calendar-validation-message" name="lps-fields-calendar-validation-message" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_('COM_LPS_VALIDATION_MESSAGE_FIELD_TOOLTIP'); ?>"><?php echo JText::_('COM_LPS_INVALID_INPUT'); ?></textarea>
        </div>
    </div>  
</div>
<div id="calendar-attributes" style="display:none;">
    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_DATE_FORMAT_FIELD_TOOLTIP'); ?>
        </label>
        <div class="uk-form-controls">
            <select id="lps-fields-calendar-date-format" name="lps-fields-calendar-date-format" data-uk-tooltip title="<?php echo JText::_('COM_LPS_DATE_FORMAT_FIELD_TOOLTIP'); ?>">
                <option value=""><?php echo JText::_('COM_LPS_SELECT'); ?></option>
                <option value="dd.mm.yy">dd.mm.yyyy</option>
                <option value="mm.dd.yy">mm.dd.yyyy</option>
                <option value="yy.mm.dd">yyyy.mm.dd</option>
                <option value="yy.dd.mm">yyyy.dd.mm</option>
                <option value="dd-mm-yy">dd-mm-yyyy</option>
                <option value="mm-dd-yy">mm-dd-yyyy</option>
                <option value="yy-mm-dd">yyyy-mm-dd</option>
                <option value="yy-dd-mm">yyyy-dd-mm</option>
                <option value="dd/mm/yy">dd/mm/yyyy</option>
                <option value="mm/dd/yy">mm/dd/yyyy</option>
                <option value="yy/mm/dd">yyyy/mm/dd</option>
                <option value="yy/dd/mm">yyyy/dd/mm</option>
            </select>
        </div>
    </div>  

</div>

<div style="height:15px;"></div>








