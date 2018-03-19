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

<h3><?php echo JText::_('COM_LPS_NEW_BUTTON_FORM_HEADING'); ?></h3>

<div class="uk-form-row">
    <label class="uk-form-label" for="">
        <?php echo JText::_( 'COM_LPS_NAME_FIELD_NAME' ); ?>
    </label>
    <div class="uk-form-controls">
        <input name="lps-fields-button-name" id="lps-fields-button-name" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_NAME_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
    </div>
</div>

<div style="height:15px;"></div>

<div class="uk-form-controls">
    <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_( 'COM_LPS_PUBLISHED_FIELD_NAME' ); ?></span> <i id="lps-fields-button-published" onclick="toggleIcon(0,'published','lps-fields-button-published')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
</div>

<div style="height:15px;"></div>

<div class="uk-form-row">
    <label class="uk-form-label" for="">
        <?php echo JText::_('COM_LPS_SELECT_FORM_FIELD_NAME'); ?>
    </label>
    <div class="uk-form-controls">
        <select name="lps-fields-button-form-id" id="lps-fields-button-form-id">
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
        <input name="lps-fields-button-caption" id="lps-fields-button-caption" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_CAPTION_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
    </div>
</div>

<div style="height:15px;"></div>

<div class="uk-form-row">
    <label class="uk-form-label" for="">
        <?php echo JText::_('COM_LPS_LABEL_FIELD_NAME'); ?>
    </label>
    <div class="uk-form-controls">
        <input type="text" id="lps-fields-button-label" name="lps-fields-button-label" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_('COM_LPS_BUTTON_LABEL_FIELD_TOOLTIP'); ?>">
    </div>
</div>

<div style="height:15px;"></div>

<div class="uk-form-row">
    <label class="uk-form-label" for="">
        <?php echo JText::_('COM_LPS_DESCRIPTION_FIELD_NAME'); ?>
    </label>
    <div class="uk-form-controls">
    	<textarea id="lps-fields-button-description" name="lps-fields-button-description" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_('COM_LPS_DESCRIPTION_FIELD_TOOLTIP'); ?>"></textarea>
    </div>
</div>










