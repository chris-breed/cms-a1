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

<form class="uk-form uk-form-stacked" method="post" action="index.php?option=com_lps&amp;view=landingpages&amp;task=LandingPages.editLandingPageItem" name="editLandingPageForm">

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_( 'COM_LPS_NAME_FIELD_NAME' ); ?>
        </label>
        <div class="uk-form-controls">
            <input name="lps-landing-pages-edit-name" id="lps-landing-pages-edit-name" value="" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_NAME_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1">
            <div id="lps-landing-pages-edit-name-validation-msg" style="display:none;color:#D85030;"></div>
        </div>
    </div>

    <div style="height:15px;"></div>

    <div class="uk-form-controls">
        <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_( 'COM_LPS_PUBLISHED_FIELD_NAME' ); ?></span> <i id="lps-landing-pages-edit-published" onclick="toggleIcon(0,'published','lps-landing-pages-edit-published')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
    </div>
        
    <div style="height:15px;"></div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_( 'COM_LPS_DESCRIPTION_FIELD_NAME' ); ?>
        </label>
        <div class="uk-form-controls">
            <textarea type="text" name="lps-landing-pages-edit-description" id="lps-landing-pages-edit-description" rows="4" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_DESCRIPTION_FIELD_TOOLTIP' ); ?>" class="uk-width-1-1"></textarea>
        </div>
    </div>

    <div style="height:15px;"></div>

    <input type="hidden" name="lps-landing-pages-edit-published" id="lps-landing-pages-edit-published-value" value="1">
    <input type="hidden" name="lps-landing-pages-edit-item-id" id="lps-landing-pages-edit-item-id" value="0">
</form>





