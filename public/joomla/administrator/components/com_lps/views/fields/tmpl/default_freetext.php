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

<h3><?php echo JText::_('COM_LPS_NEW_FREETEXT_FORM_HEADING'); ?></h3>


<div class="uk-form-row">
    <label class="uk-form-label" for="">
        <?php echo JText::_( 'COM_LPS_NAME_FIELD_NAME' ); ?>
    </label>
    <div class="uk-form-controls">
        <input name="lps-fields-freetext-name" id="lps-fields-freetext-name" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_NAME_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
        <div id="lps-fields-freetext-name-validation-msg" style="display:none;color:#D85030;"></div>
    </div>
</div>

<div style="height:15px;"></div>

<div class="uk-form-controls">
    <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_( 'COM_LPS_PUBLISHED_FIELD_NAME' ); ?></span> <i id="lps-fields-freetext-published" onclick="toggleIcon(0,'published','lps-fields-freetext-published')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
</div>

<div style="height:15px;"></div>

<div class="uk-form-row">
    <label class="uk-form-label" for="">
        <?php echo JText::_('COM_LPS_SELECT_FORM_FIELD_NAME'); ?>
    </label>
    <div class="uk-form-controls">
        <select name="lps-fields-freetext-form-id" id="lps-fields-freetext-form-id">
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
        <?php echo JText::_('COM_LPS_TEXT_FIELD_NAME'); ?>
    </label>
    <div class="uk-form-controls">
    	<textarea id="lps-fields-freetext-text" name="lps-fields-freetext-text" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_('COM_LPS_TEXT_FIELD_TOOLTIP'); ?>"></textarea>
        <div id="lps-fields-freetext-text-validation-msg" style="display:none;color:#D85030;"></div>
    </div>
</div>




<div style="height:15px;"></div>








