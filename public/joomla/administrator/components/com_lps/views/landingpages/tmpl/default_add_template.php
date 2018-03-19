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
<form class="uk-form uk-form-stacked" method="post" action="index.php?option=com_lps&amp;view=landingpages&amp;task=LandingPages.associateTemplate" name="associateTemplateForm">
	<div style="padding-top:60px;padding-bottom:60px;">
	<?php
	if (count($this->templates) > 0) {
		echo '<select name="lps-landing-pages-add-template-select" id="lps-landing-pages-add-template-select" class="uk-form-large uk-width-1-1">';
		echo '<option value="">'.JText::_('COM_LPS_SELECT').'</option>';
		foreach ($this->templates as $template) {
			echo '<option value="'.$template->id.'">'.$template->name.'</option>';
		}
		echo '</select>';
		echo '<input type="hidden" name="lps-landing-pages-add-template-landing-page-id" id="lps-landing-pages-add-template-landing-page-id" value="0">';
	} else {
		echo '<div class="uk-text-center"><h2>'.JText::_('COM_LPS_LANDING_PAGES_NO_CREATED_TEMPLATES').'.</h2>';
			echo '<a href="index.php?option=com_lps&view=templates">
						<i class="uk-icon-plus"></i> '.JText::_( "COM_LPS_ADD_TEMPLATE" ).'
				  </a> '.JText::_('COM_LPS_TO_CONTINUE').'.';
		echo '</div>';
	}
	?>
	</div>
</form>

