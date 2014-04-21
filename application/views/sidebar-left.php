      <ul id="sidebar-left">
      	<?php if(isset($lineups)) { ?>
        <!--<li class="first-child no-submenu<?php if(sizeof($this->uri->segment_array()) == 1) { echo ' active'; } ?>">
          <a href="<?php echo $base_url . $this->uri->slash_segment(1); ?>"><?php echo lang('featured'); ?></a>
        </li>-->
        <?php } ?>
        <?php $this->load->view('sub-menu.php'); ?>
      </ul> <!-- //sidebar-left -->
