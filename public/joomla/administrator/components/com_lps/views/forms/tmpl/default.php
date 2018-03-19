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

$document = JFactory::getDocument(); ?>
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
	var lpsLandingPagesSearch = "<?php echo $this->state->get('lps_forms_search'); ?>";
</script>
<div class="lps-body">

		<div id="j-sidebar-container" class="span2">
			<?php //echo $this->sidebar; ?>

			<div class="uk-panel uk-panel-box">
	            <ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav="">
	                <li><a href="index.php?option=com_lps&amp;view=landingpages"><?php echo JText::_( 'COM_LPS_LANDING_PAGES_TITLE' ); ?></a></li>
	                <li><a href="index.php?option=com_lps&amp;view=templates"><?php echo JText::_( 'COM_LPS_TEMPLATES_TITLE' ); ?></a></li>
	                <li class="uk-active"><a href="index.php?option=com_lps&amp;view=forms"><?php echo JText::_( 'COM_LPS_FORMS_TITLE' ); ?></a></li>
	                <li><a href="index.php?option=com_lps&amp;view=fields"><?php echo JText::_( 'COM_LPS_FIELDS_TITLE' ); ?></a></li>
	                <li><a href="index.php?option=com_lps&amp;view=submissions"><?php echo JText::_( 'COM_LPS_SUBMISSIONS_TITLE' ); ?></a></li>
	                <li><a href="index.php?option=com_lps&amp;view=leads"><?php echo JText::_( 'COM_LPS_LEADS_TITLE' ); ?></a></li>
	            </ul>
	        </div>

		</div>

		<div id="j-main-container" class="span10">

			<div class="uk-panel uk-panel-box">
				<div class="uk-clearfix">
					<div class="uk-float-left" style="height:30px;">
						<form class="uk-form" action="index.php?option=com_lps&amp;view=forms" method="post" name="LpsFormsSearchForm" id="LpsFormsSearchForm">
							<input type="text" value="<?php echo $this->state->get('lps_forms_search'); ?>" name="lps-forms-search" id="lps-forms-search" placeholder="<?php echo JText::_('COM_LPS_SEARCH_PLACEHOLDER'); ?>">					
							<span style="position:relative;bottom:5px;">
								<?php if ($this->state->get('lps_forms_search')) { ?>
									<a id="lps-forms-clear-search" class="uk-button uk-button-danger" onclick="clearFormsSearch()" href="javascript:void(0);"><i class="uk-icon-times"></i></a>							
								<?php } else { ?>
									<a id="lps-forms-clear-search" style="display:none;" class="uk-button uk-button-danger" onclick="clearFormsSearch()" href="javascript:void(0);"><i class="uk-icon-times"></i></a>	
								<?php } ?>
								<span style="padding-right:15px;">
									<a class="uk-button" onclick="searchLpsForms()" href="javascript:void(0);"><i class="uk-icon-search"></i></a>
								</span>
							</span>
						</form>
					</div>
					<div class="uk-float-right">
						<a href="javascript:void(0);" class="uk-button uk-button-primary" data-uk-modal="{target:'#lps-forms-create-new'}"><i class="uk-icon-plus"></i> <?php echo JText::_( 'COM_LPS_NEW_FORM' ); ?></a>
					</div>
				</div>
			</div>

			<div style="height:15px;"></div>

			<div class="uk-panel uk-panel-box" style="background-color:#fff;">

				<form action="<?php echo JRoute::_('index.php?option=com_lps'); ?>" method="post" name="adminForm" id="adminForm" class="uk-form">
				<table class="uk-table uk-table-striped uk-table-hover">
					<thead>
						<tr>						
							<th>
								<?php echo JText::_( 'COM_LPS_NAME_FIELD_NAME' ); ?>
							</th>	
							<th><?php echo JText::_( 'COM_LPS_FIELDS_FIELD_NAME' ); ?></th>		
							<!--<th>Submissions</th>-->								
							<th width="1%" class="nowrap center">
								<?php echo JText::_( 'COM_LPS_PUBLISHED_FIELD_NAME' ); ?>
							</th>
				            <th width="1%" class="nowrap center"></th>
						</tr>
					</thead>
					<tbody id="lps-forms-sortable">
					<?php

					if (count($this->items) > 0) {
						foreach ($this->items as $i => $item) { ?>
							<tr>
								<td>
									<a href="javascript:void(0);" onclick="launchEditFormModal(<?php echo $item->id; ?>)">
										<?php echo $item->name; ?>
									</a>
								</td>
								<td>
									<a href="index.php?option=com_lps&amp;view=fields&amp;lps-fields-form=<?php echo $item->id; ?>">
										<?php echo JText::_('COM_LPS_FIELDS_VIEW_FIELDS'); ?>
									</a>
								</td>
								<!--<td>
									<?php //echo LpsHelper::getFormSubmissionCount($item->id); ?>
								</td> -->
								<td>
									<?php if ($item->published == 1) { ?>
											<div class="uk-text-center"><a href="javascript:void(0);" onclick="togglePublishing(0,<?php echo $item->id; ?>)"><i class="uk-icon-check-circle-o" style="font-size:20px;color:rgba(101, 159, 19, 1) !important;"></i></a></div>
									<?php } else { ?>
											<div class="uk-text-center"><a href="javascript:void(0);" onclick="togglePublishing(1,<?php echo $item->id; ?>)"><i class="uk-icon-times-circle" style="font-size:20px;color:rgba(216, 80, 48, 1) !important;"></i></a></div>
									<?php } ?>
								</td>												
								<td>
									<div class="uk-text-center">
										<a href="javascript:void(0);" class="uk-close" onclick="removeFormItem(<?php echo $item->id; ?>)"></a>
									</div>
								</td>								
							</tr>	

						<?php } ?>
					<?php } else { ?>

						<?php if ($this->state->get('lps_forms_search')) { ?>
									<tr>
										<td colspan="10" style="text-align:center;">	
											<div style="padding-bottom:75px;padding-top:75px;">
												<h3><i class="uk-icon-times-circle-o"></i> <?php echo JText::_( 'COM_LPS_FORMS_NO_SEARCH_RESULTS' ); ?> '<?php echo $this->state->get('lps_forms_search'); ?>'. <a href="javascript:void(0);" onclick="clearArtCalendarSearch()"><?php echo JText::_( 'COM_LPS_CLEAR_SEARCH' ); ?></a>.</h3>
											</div>
										</td>
									</tr>
						<?php } else { ?>
									<tr>
										<td colspan="10" style="text-align:center;">	
											<div style="padding-bottom:75px;padding-top:75px;">
												<h3><a href="javascript:void(0);" data-uk-modal="{target:'#lps-forms-create-new'}"><i class="uk-icon-plus"></i> <?php echo JText::_( 'COM_LPS_FORMS_CREATE_FORM' ); ?></a> <?php echo JText::_( 'COM_LPS_TO_GET_STARTED' ); ?></h3>
											</div>
										</td>
									</tr>
						<?php } ?>
					<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="10" style="text-align:center;">					
									
								<!--<div class="uk-float-left">
									<select style="width:100px;">
										<option value="0">All</option>
										<option value="5">5</option>
										<option value="10">10</option>
										<option value="20">20</option>
										<option value="30">30</option>
										<option value="40">40</option>
										<option value="50">50</option>
									</select>
								</div>-->

								<!--<ul class="uk-pagination">
	                                <li class="uk-disabled"><span><i class="uk-icon-angle-double-left"></i></span></li>
	                                <li class="uk-active"><span>1</span></li>
	                                <li><a href="#">2</a></li>
	                                <li><a href="#">3</a></li>
	                                <li><a href="#">4</a></li>
	                                <li><span>...</span></li>
	                                <li><a href="#">20</a></li>
	                                <li><a href="#"><i class="uk-icon-angle-double-right"></i></a></li>
	                            </ul>-->
										
							</td>
						</tr>
					</tfoot>	
				</table>
				</form>

				<!--<input type="hidden" name="encouragement_select" id="encouragement_select"> -->
				<input type="hidden" name="task" value="" />
				<input type="hidden" name="boxchecked" value="0" />
				<input type="hidden" name="filter_order" value="<?php //echo $listOrder; ?>" />
				<input type="hidden" name="filter_order_Dir" value="<?php //echo $listDirn; ?>" />
				<?php echo JHtml::_('form.token'); ?>

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

<form method="post" action="index.php?option=com_lps&amp;task=Forms.togglePublishing" name="lpsFormsTogglePublishing" id="lpsFormsTogglePublishing">
	<input type="hidden" name="lps-forms-state" id="lps-forms-state" value="0">
	<input type="hidden" name="lps-forms-item-id" id="lps-forms-item-id" value="0">
</form>
<form method="post" action="index.php?option=com_lps&amp;task=Forms.removeFormItem" name="lpsFormsRemoveForm" id="lpsFormsRemoveForm">
	<input type="hidden" name="lps-forms-remove-item-id" id="lps-forms-remove-item-id" value="0">
</form>

<!-- This is the create new form modal -->
<div id="lps-forms-create-new" class="uk-modal">
    <div class="uk-modal-dialog">
    	<a class="uk-modal-close uk-close"></a>
    	<div class="uk-modal-header">
    		<h2><i class="uk-icon-plus"></i> <?php echo JText::_( 'COM_LPS_NEW_FORM' ); ?></h2>
    	</div>
        <?php echo $this->loadTemplate('new'); ?>
        <div class="uk-modal-footer">
        	<div class="uk-clearfix">
	        	<div class="uk-float-right">
	        		<span style="padding-right:10px;">
	        			<a class="uk-button uk-button-default uk-button-large" href="javascript:void(0);" onclick="closeNewFormModal()"><?php echo JText::_( 'COM_LPS_CANCEL_ACTION' ); ?></a>
	        		</span>
	        		<a class="uk-button uk-button-primary uk-button-large" href="javascript:void(0);" onclick="saveNewForm()"> <?php echo JText::_( 'COM_LPS_SAVE_ACTION' ); ?></a>
	        		<span style="padding-right:10px;" id="lps-forms-new-calendar-loading"></span>
	        	</div>
	        </div>
        </div>
    </div>
</div>

<!-- This is the edit form modal -->
<div id="lps-forms-edit-form" class="uk-modal">
    <div class="uk-modal-dialog">
    	<a class="uk-modal-close uk-close"></a>
    	<div class="uk-modal-header">
    		<h2><i class="uk-icon-edit"></i> <?php echo JText::_( 'COM_LPS_EDIT_FORM' ); ?></h2>
    	</div>
        <?php echo $this->loadTemplate('edit'); ?>
        <div class="uk-modal-footer">
        	<div class="uk-clearfix">
	        	<div class="uk-float-right">
	        		<span style="padding-right:10px;">
	        			<a class="uk-button uk-button-default uk-button-large" href="javascript:void(0);" onclick="closeEditFormModal()"><?php echo JText::_( 'COM_LPS_CANCEL_ACTION' ); ?></a>
	        		</span>
	        		<a class="uk-button uk-button-primary uk-button-large" href="javascript:void(0);" onclick="editForm()"> <?php echo JText::_( 'COM_LPS_SAVE_ACTION' ); ?></a>
	        		<span style="padding-right:10px;" id="lps-forms-edit-calendar-loading"></span>
	        	</div>
	        </div>
        </div>
    </div>
</div>



