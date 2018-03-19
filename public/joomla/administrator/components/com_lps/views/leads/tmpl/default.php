<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

// no direct access
defined('_JEXEC') or die;

$document = JFactory::getDocument(); 
$statuses = array('cold' => JText::_('COM_LPS_SUBMISSIONS_STATUS_COLD'),
				  'warm' => JText::_('COM_LPS_SUBMISSIONS_STATUS_WARM'),
				  'hot' => JText::_('COM_LPS_SUBMISSIONS_STATUS_HOT'),
				  'customer' => JText::_('COM_LPS_SUBMISSIONS_STATUS_CUSTOMER'));
?>
<style>
	.lps-batch-processing-actions-tags {
		padding-left:5px !important;
		padding-right:5px !important;
		padding-bottom:5px !important;
		padding-top:5px !important;
		background-color:#ffffff;/*44618B*/
		border:1px solid #b3b3ad;
		/*color:#fff;*/
		font-size:9px;
		line-height:10px;
		border-radius:3px;
	}
</style>
<script type="text/javascript">
	var lpsLeadsSearch = "<?php echo $this->state->get('lps_leads_search'); ?>";
</script>
<div class="lps-body">

		<div id="j-sidebar-container" class="span2">
			<?php //echo $this->sidebar; ?>

			<div class="uk-panel uk-panel-box">

	            <ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav="">
	                <li><a href="index.php?option=com_lps&amp;view=landingpages"><?php echo JText::_( 'COM_LPS_LANDING_PAGES_TITLE' ); ?></a></li>
	                <li><a href="index.php?option=com_lps&amp;view=templates"><?php echo JText::_( 'COM_LPS_TEMPLATES_TITLE' ); ?></a></li>
	                <li><a href="index.php?option=com_lps&amp;view=forms"><?php echo JText::_( 'COM_LPS_FORMS_TITLE' ); ?></a></li>
	                <li><a href="index.php?option=com_lps&amp;view=fields"><?php echo JText::_( 'COM_LPS_FIELDS_TITLE' ); ?></a></li>
	                <li><a href="index.php?option=com_lps&amp;view=submissions"><?php echo JText::_( 'COM_LPS_SUBMISSIONS_TITLE' ); ?></a></li>
	                <li class="uk-active"><a href="index.php?option=com_lps&amp;view=leads"><?php echo JText::_( 'COM_LPS_LEADS_TITLE' ); ?></a></li>
	            </ul>

	        </div>

		</div>

		<div id="j-main-container" class="span10">

			<div class="uk-panel uk-panel-box">
				<div class="uk-clearfix">
					<div class="uk-float-left"> <!-- style="height:30px;"-->
						<form class="uk-form" action="index.php?option=com_lps&amp;view=leads" method="post" name="LpsLeadsFilterForm" id="LpsLeadsFilterForm" style="margin:0 !important;">
							<select name="lps-leads-status-filter" onchange="this.form.submit()">
								<option value=""><?php echo JText::_('COM_LPS_LEADS_SELECT_STATUS'); ?></option>
								<?php
								foreach ($statuses as $key => $value) {
									if ($this->state->get('lps-leads-status-filter') == $key) {
										echo '<option selected="selected" value="'.$key.'">'.$value.'</option>';
									} else {
										echo '<option value="'.$key.'">'.$value.'</option>';
									}	
								} ?>
							</select>
						</form>
					</div>
					<div class="uk-float-right">	
					    <div class="uk-form-row">
					    	<form class="uk-form" action="index.php?option=com_lps&amp;view=leads" method="post" name="LpsPaginationForm" id="LpsPaginationForm" style="margin:0 !important;">
						    	<?php $displayChoices = array(5,10,20,30,40,50); ?>
								<select style="width:100px;" name="lps-limit" id="lps-limit" data-uk-tooltip title="<?php echo JText::_('Show'); ?>" onchange="this.form.submit()">
									<?php foreach ($displayChoices as $choice) { ?>
										<?php if ($choice == $this->limit) { ?>
													<option selected="selected" value="<?php echo $choice; ?>"><?php echo $choice; ?></option>
										<?php } else { ?>
													<option value="<?php echo $choice; ?>"><?php echo $choice; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
								<input type="hidden" name="lps-limitstart" id="lps-limitstart" value="0"> 
							</form>				        	
					    </div>
					</div>					
				</div>
			</div>

			<div style="height:15px;"></div>

			<div class="uk-panel uk-panel-box" style="background-color:#fff;">

				<table class="uk-table uk-table-striped uk-table-hover">
					<thead>
						<tr>
							<th>
								<?php echo JText::_('COM_LPS_EMAIL_FIELD_NAME'); ?>
							</th>							
							<th>
								<?php echo JText::_('COM_LPS_DATE_FIELD_NAME'); ?>
							</th>		
							<th>
								<?php echo JText::_('COM_LPS_SUBMISSIONS_SUBMISSION'); ?>
							</th>				
							<th class="uk-text-center">
								<?php echo JText::_('COM_LPS_STATUS_FIELD_NAME'); ?>
							</th>					
							<th width="1%" class="nowrap center">
				
							</th>            
						</tr>
					</thead>
					<tbody id="lps-landing-pages-sortable">
					<?php

					if (count($this->items) > 0) {
						$itemIds = array();
						foreach ($this->items as $i => $item) { ?>
							<tr>
								<td>
									<!--<a href="javascript:void(0);">--> <!-- onclick="launchSubmissionDataModal(<?php echo $item->id; ?>)"-->
										<?php echo $item->email; ?>
									<!--</a>-->
								</td>
								<td>
									<?php echo LpsHelper::formatDate($item->created); ?>
								</td>
								<td>
									<a href="index.php?option=com_lps&amp;view=submissions&amp;id=<?php echo $item->submission_id; ?>"><?php echo JText::_('COM_LPS_SUBMISSIONS_SUBMISSION_LABEL'); ?>-00<?php echo $item->submission_id; ?></a>
								</td>
								<td class="uk-text-center">
									<?php 
									if ($item->status == 'cold') {
										echo '<a id="lp-submission-status-link-'.$item->id.'" href="javascript:void(0);" onclick="showStatusSelect('.$item->id.')"><i class="uk-icon-frown-o"></i> '.JText::_('COM_LPS_SUBMISSIONS_STATUS_COLD').'</a>';
									} elseif ($item->status == 'warm') {
										echo '<a id="lp-submission-status-link-'.$item->id.'" href="javascript:void(0);" onclick="showStatusSelect('.$item->id.')"><i class="uk-icon-sun-o"></i> '.JText::_('COM_LPS_SUBMISSIONS_STATUS_WARM').'</a>';
									} elseif ($item->status == 'hot') {
										echo '<a id="lp-submission-status-link-'.$item->id.'" href="javascript:void(0);" onclick="showStatusSelect('.$item->id.')"><i class="uk-icon-fire"></i> '.JText::_('COM_LPS_SUBMISSIONS_STATUS_HOT').'</a>';
									} elseif ($item->status == 'customer') {
										echo '<a id="lp-submission-status-link-'.$item->id.'" href="javascript:void(0);" onclick="showStatusSelect('.$item->id.')"><i class="uk-icon-usd"></i> '.JText::_('COM_LPS_SUBMISSIONS_STATUS_CUSTOMER').'</a>';
									} else {
										echo '<a id="lp-submission-status-link-'.$item->id.'" href="javascript:void(0);" onclick="showStatusSelect('.$item->id.')">'.JText::_('COM_LPS_SUBMISSIONS_SET_STATUS').'</a>';
									} 

									?>
								</td>	
								<td>
									<a href="javascript:void(0);" class="uk-close" onclick="removeLeadItem(<?php echo $item->id; ?>)"></a>
								</td>																		
							</tr>	

						<?php } ?>
					<?php } else { ?>

						<?php if ($this->state->get('lps_leads_search')) { ?>
									<tr>
										<td colspan="10" style="text-align:center;">	
											<div style="padding-bottom:75px;padding-top:75px;">
												<h3><i class="uk-icon-times-circle-o"></i> <?php echo JText::_( 'COM_LPS_LEADS_NO_SEARCH_RESULTS' ); ?> '<?php echo $this->state->get('lps_leads_search'); ?>'. <a href="javascript:void(0);" onclick="clearLpsLeadsSearch()"><?php echo JText::_( 'COM_LPS_CLEAR_SEARCH' ); ?></a>.</h3>
											</div>
										</td>
									</tr>
						<?php } else { ?>
									<tr>
										<td colspan="10" style="text-align:center;">	
											<div style="padding-bottom:75px;padding-top:75px;">
												<h3><?php echo JText::_('COM_LPS_LEADS_NO_LEADS_YET'); ?> <a href="index.php?option=com_lps&amp;view=submissions"><?php echo JText::_('COM_LPS_LEADS_SUBMISSIONS'); ?></a>.</h3>
											</div>
										</td>
									</tr>
						<?php } ?>
					<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="10" style="text-align:center;">					
									
								<div class="uk-text-center uk-margin-top">
									<ul class="uk-pagination">
										<?php echo LpsHelper::getPaginationPages($this->item_count,$this->limit,$this->limitstart); ?>
		                            </ul>
								</div>
										
							</td>
						</tr>
					</tfoot>	
				</table>

				<div class="uk-width-1-1">
					<div style="height:25px;"></div>
					<div class="uk-float-right">
						<span style="padding-right:5px;position:relative;bottom:2px;"><img src="components/com_lps/assets/images/joomlasales-trans-16.png"></span><span style="font-size:16px;"><?php echo JText::_( 'COM_LPS_BY_SIGNATURE' ); ?> <a href="http://joomlasales.com" target="_blank" style="font-family: 'Viga';">JoomlaSales.com</a></span> &nbsp; <span style="font-size:16px;"><i class="uk-icon-copyright"></i> 2015</span>
					</div>
				</div>

			</div>

		</div>
	</form>     
</div>
<form method="post" action="index.php?option=com_lps&amp;task=Leads.removeLeadItem" name="lpsLeadsRemoveItem" id="lpsLeadsRemoveItem">
	<input type="hidden" name="lps-leads-remove-item" id="lps-leads-remove-item" value="0">
</form>


<!-- submission item value data -->
<div id="lps-submission-item-data-modal" class="uk-modal">
    <div class="uk-modal-dialog">
    	<a class="uk-modal-close uk-close"></a>
    	<div class="uk-modal-header">
    		<h2><i class="uk-icon-info-circle"></i> <?php echo JText::_('COM_LPS_SUBMISSIONS_SUBMISSION'); ?></h2>
    	</div>
        <div id="lps-submission-data-html-area">

        </div>
    </div>
</div>

<!-- select lead status -->
<div id="lps-leads-status-select-modal" class="uk-modal">
    <div class="uk-modal-dialog">
    	<a class="uk-modal-close uk-close"></a>
    	<div class="uk-modal-header">
    		<h2><i class="uk-icon-info-circle"></i> <?php echo JText::_('COM_LPS_SUBMISSIONS_SET_STATUS'); ?></h2>
    	</div>
        <form method="post" action="index.php?option=com_lps&amp;task=Leads.changeStatus" class="uk-form">
	    	<div style="padding-top:60px;padding-bottom:60px;">
		    	<select name="lps-leads-status-select" id="lps-leads-status-select" onchange="this.form.submit()" class="uk-width-1-1 uk-form-large">
		    		<option value="">select...</option>
		    		<option value=""><?php echo JText::_('COM_LPS_SELECT'); ?></option>
		    		<option value="cold"><i class="uk-icon-frown-o"></i> <?php echo JText::_('COM_LPS_SUBMISSIONS_STATUS_COLD'); ?></option>
		    		<option value="warm"><i class="uk-icon-sun-o"></i> <?php echo JText::_('COM_LPS_SUBMISSIONS_STATUS_WARM'); ?></option>
		    		<option value="hot"><i class="uk-icon-fire"></i> <?php echo JText::_('COM_LPS_SUBMISSIONS_STATUS_HOT'); ?></option>
		    		<option value="customer"><i class="uk-icon-usd"></i> <?php echo JText::_('COM_LPS_SUBMISSIONS_STATUS_CUSTOMER'); ?></option>
		    	</select>
	    	</div>
	    	<input type="hidden" name="lps-leads-status-select-id" id="lps-leads-status-select-id" value="0">
    	</form>
        <div class="uk-modal-footer">
        	<div class="uk-clearfix">
	        	<div class="uk-float-right">
	        		<span style="padding-right:10px;">
	        			<a class="uk-button uk-button-default uk-button-large" href="javascript:void(0);" onclick="closeStatusSelect()"><?php echo JText::_( 'COM_LPS_CANCEL_ACTION' ); ?></a>
	        		</span>
	        	</div>
	        </div>
        </div>
    </div>
</div>

