<div id="body" class="padded clearfix">
	<div id="results-wrapper">
		<div class="bar pagination">
		<p><?php echo str_replace('{0}', $term, lang('zero-results')) ; ?></p>
		</div>
		<div class="no-results">
		<?php echo str_replace('{0}', $term, lang('search-no-results')) ; ?>
		</div>
	</div>
 