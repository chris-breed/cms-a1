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

<form class="uk-form uk-form-stacked" method="post" action="index.php?option=com_lps&amp;view=forms&amp;task=Forms.editFormItem" name="editFormItem">

    <ul class="uk-tab" data-uk-tab>
        <li class="uk-active"><a href="javascript:void(0);" onclick="showEditFormBasicArea()"><?php echo JText::_('COM_LPS_BASIC_FORM_HEADING'); ?></a></li>
        <li><a href="javascript:void(0);" onclick="showEditFormUserEmailArea()"><?php echo JText::_('COM_LPS_FORMS_USER_EMAIL_NOTIFICATIONS'); ?></a></li>
        <li><a href="javascript:void(0);" onclick="showEditFormAdminEmailArea()"><?php echo JText::_('COM_LPS_FORMS_ADMIN_EMAIL_NOTIFICATIONS'); ?></a></li>
    </ul>
    <div id="lps-forms-edit-form-basic-area">

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_( 'COM_LPS_NAME_FIELD_NAME' ); ?>
                </label>
                <div class="uk-form-controls">
                    <input name="lps-forms-edit-name" id="lps-forms-edit-name" value="" type="text" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_NAME_FIELD_TOOLTIP' ); ?>">
                    <div id="lps-forms-edit-name-validation-msg" style="display:none;color:#D85030;"></div>
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-controls">
                <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_( 'COM_LPS_PUBLISHED_FIELD_NAME' ); ?></span> <i id="lps-forms-edit-published" onclick="toggleIcon(0,'published','lps-forms-edit-published')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
            </div>
          
            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_( 'COM_LPS_DESCRIPTION_FIELD_NAME' ); ?>
                </label>
                <div class="uk-form-controls">
                    <textarea class="uk-width-1-1" type="text" name="lps-forms-edit-description" id="lps-forms-edit-description" cols="28" rows="4" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_DESCRIPTION_FIELD_TOOLTIP' ); ?>"></textarea>
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_( 'COM_LPS_RETURN_URL_FIELD_NAME' ); ?>
                </label>
                <div class="uk-form-controls">
                    <input name="lps-forms-edit-return-url" id="lps-forms-edit-return-url" value="" type="text" class="uk-width-1-1" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_RETURN_URL_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_( 'COM_LPS_THANK_YOU_MESSAGE_FIELD_NAME' ); ?>
                </label>
                <div class="uk-form-controls">
                    <textarea class="uk-width-1-1" type="text" name="lps-forms-edit-thank-you-message" id="lps-forms-edit-thank-you-message" cols="28" rows="4" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_THANK_YOU_MESSAGE_FIELD_TOOLTIP' ); ?>"></textarea>
                </div>
            </div>
    </div>
    <div id="lps-forms-edit-form-user-email-area" style="display:none;">
            
            <div style="height:15px;"></div>

            <div class="uk-form-controls">
                <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_('COM_LPS_MODE_FIELD_NAME'); ?></span> <i id="lps-forms-edit-user-email-mode" onclick="toggleIcon(0,'user-email-mode','lps-forms-edit-user-email-mode')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_EMAIL_MESSAGE_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <textarea class="uk-width-1-1" type="text" name="lps-forms-edit-user-email-text" id="lps-forms-edit-user-email-text" cols="28" rows="4" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_EMAIL_MESSAGE_FIELD_TOOLTIP' ); ?>"></textarea>
                </div>
            </div>

            <div style="height:15px;"></div>

            <!--<div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php //echo JText::_('COM_LPS_TO_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-user-email-to" id="lps-forms-edit-user-email-to" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_TO_FIELD_TOOLTIP' ); ?>">
                </div>
            </div> 

            <div style="height:15px;"></div>-->

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_CC_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-user-email-cc" id="lps-forms-edit-user-email-cc" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_CC_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                   <?php echo JText::_('COM_LPS_BCC_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-user-email-bcc" id="lps-forms-edit-user-email-bcc" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_BCC_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_FROM_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-user-email-from" id="lps-forms-edit-user-email-from" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_FROM_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_FROM_NAME_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-user-email-from-name" id="lps-forms-edit-user-email-from-name" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_FROM_NAME_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>            

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_REPLY_TO_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-user-email-reply-to" id="lps-forms-edit-user-email-reply-to" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_REPLY_TO_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_SUBJECT_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-user-email-subject" id="lps-forms-edit-user-email-subject" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_SUBJECT_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>
    </div>
    <div id="lps-forms-edit-form-admin-email-area" style="display:none;">
            
            <div style="height:15px;"></div>

            <div class="uk-form-controls">
                <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_('COM_LPS_MODE_FIELD_NAME'); ?></span> <i id="lps-forms-edit-admin-email-mode" onclick="toggleIcon(0,'admin-email-mode','lps-forms-edit-admin-email-mode')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_EMAIL_MESSAGE_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <textarea class="uk-width-1-1" type="text" name="lps-forms-edit-admin-email-text" id="lps-forms-edit-admin-email-text" cols="28" rows="4" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_EMAIL_MESSAGE_FIELD_TOOLTIP' ); ?>"></textarea>
                </div>
            </div>

            <div style="height:15px;"></div>

            <!--<div class="uk-form-row">
                <label class="uk-form-label" for="">
                    To
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-admin-email-to" id="lps-forms-edit-admin-email-to" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_DESCRIPTION_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>-->

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_CC_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-admin-email-cc" id="lps-forms-edit-admin-email-cc" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_CC_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_BCC_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-admin-email-bcc" id="lps-forms-edit-admin-email-bcc" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_BCC_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_FROM_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-admin-email-from" id="lps-forms-edit-admin-email-from" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_FROM_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_FROM_NAME_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-admin-email-from-name" id="lps-forms-edit-admin-email-from-name" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_FROM_NAME_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_REPLY_TO_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-admin-email-reply-to" id="lps-forms-edit-admin-email-reply-to" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_REPLY_TO_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>

            <div style="height:15px;"></div>

            <div class="uk-form-row">
                <label class="uk-form-label" for="">
                    <?php echo JText::_('COM_LPS_SUBJECT_FIELD_NAME'); ?>
                </label>
                <div class="uk-form-controls">
                    <input class="uk-width-1-1" type="text" name="lps-forms-edit-admin-email-subject" id="lps-forms-edit-admin-email-subject" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_SUBJECT_FIELD_TOOLTIP' ); ?>">
                </div>
            </div>
    </div>

    <input type="hidden" name="lps-forms-edit-form-object" id="lps-forms-edit-form-object" value="{}">


</form>




