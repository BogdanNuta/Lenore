<!doctype html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $page_title; ?><?php echo isset($video) ? ' - ' . $video->name : ''; ?></title>
	<meta name="description" content="<?php echo isset($video) ? $video->shortDescription : ''; ?>">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/cobrand.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script src="<?php echo $base_url; ?>assets/js/libs/jquery.datatables.js"></script>
	<script type="text/javascript">
		var lang = "<?php echo $lang; ?>";
		var base_url = "<?php echo $base_url; ?>";
		var current_url = "<?php echo $base_url . $this->uri->uri_string(); ?>/";
		var lang_ratings_text = "<?php echo lang('ratings-text'); ?>";
		var lang_enter_search_term = "<?php echo lang('enter-search-term'); ?>";
		var rating = <?php echo !isset($rating) ? '0' : round($rating[0]->rating); ?>; //r:<?php echo !isset($rating) ? '0' : $rating[0]->rating; ?>

		$(document).ready(function() {

			// jQuery dataTables
			$('.datatable').dataTable({"bScrollInfinite": true,"bScrollCollapse": true,"sScrollY": "500px"});

			var site_url = "<?php echo $site_url; ?>";
		    $('.delete').live('click', function() {
		    	var comment = $(this).attr('id').split('-');
		        $.ajax({
		            url: site_url + "moderation/delete/" + comment[1],
		            success: function(data) {
						$('#tr-' + comment[1]).remove();
		            }
		        });
		    });

		    $('.clear').live('click', function() {
		    	var comment = $(this).attr('id').split('-');
		        $.ajax({
		            url: site_url + "moderation/clear/" + comment[1],
		            success: function(data) {
						$('#flagged-' + comment[1]).html('0');
		            }
		        });
		    });

	    });

	</script>
	<style text="text/css">



#container {color:#fff; padding:20px;}
.datatable {margin:10px;}
tr th {text-align:left; color:#fff; text-transform:uppercase; padding:2px 6px;
  cursor:pointer;
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  -o-border-radius: 2px;
  -ms-border-radius: 2px;
  -khtml-border-radius: 2px;
  border-radius: 2px;
  behavior: url("css/PIE.php");
  position: relative;
  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #181818), color-stop(100%, #010101));
  background: -webkit-linear-gradient(#181818, #010101);
  background: -moz-linear-gradient(#181818, #010101);
  background: -o-linear-gradient(#181818, #010101);
  background: -ms-linear-gradient(#181818, #010101);
  -pie-background: linear-gradient(#181818, #010101);
  background: linear-gradient(#181818, #010101);
}
tr td {color:#fff; padding:4px 6px; border-bottom:1px dotted #575757;}
.dataTables_length {width:200px;position:absolute; padding-left:10px;}
.dataTables_filter {margin-left:722px; width:400px;}
.dataTables_filter input {width:200px;}
.dataTables_scroll {}
.dataTables_info {padding-top:16px;}


	</style>

</head>

<body>

  <div id="container" role="main">
	<h2>Comments Moderation</h2>
	<table class="datatable">
	<thead>
		<tr>
			<th>Flags</th>
			<th nowrap="nowrap">Date</th>
			<th nowrap="nowrap">Video ID</th>
			<th></th>
			<th>Comment</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($comments as $c) {
		$datetime = strtotime($c->date);
	?>

		<tr id="tr-<?php echo $c->id; ?>">
			<td id="flagged-<?php echo $c->id; ?>"><?php echo $c->flagged; ?></td>
			<td nowrap="nowrap"><?php echo date("m/d/y g:i A",$datetime); ?></td>
			<td><a href="<?php echo $base_url; ?>home/watch/video/<?php echo $c->video; ?>" target="_blank"><?php echo $c->video; ?></a></td>
			<td nowrap="nowrap">
				<a class="delete" id="delete-<?php echo $c->id; ?>" href="javascript:void(0)">Delete</a> /
				<a class="clear" id="clear-<?php echo $c->id; ?>" href="javascript:void(0)">Clear</a>
			</td>
			<td><?php echo $c->comment; ?></td>
		</tr>
	<?php } ?>
	</tbody>

	</table>

</body>
</html>
