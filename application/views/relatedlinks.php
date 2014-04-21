		<ul>
			<?php if(isset($video->linkURL)) { ?>
				<li>
                                    <table>
                                        <tr valign="top">
                                            <td>  
                                                <a href="<?php echo $video->linkURL; ?>" target="_blank">
                                                <img src="<?php echo isset($video->customFields->relatedlinkimage) ? $video->customFields->relatedlinkimage : lang('related-link-icon-1'); ?>" alt=""></a>
                                            </td> 
                                            <td>
                                                 &nbsp;<a href="<?php echo $video->linkURL; ?>" target="_blank"><?php echo isset($video->linkText) ? $video->linkText : $video->linkURL; ?> &raquo;</a>
                                            </td> 
                                        </tr>
                                    </table>
				</li>
			<?php } ?>
			<?php if(isset($video->customFields->relatedlink2)) { ?>
				<li>
                                    <table>
                                        <tr>
                                            <td>  
                                                <a href="<?php echo $video->customFields->relatedlink2; ?>" target="_blank">
                                                <img src="<?php echo isset($video->customFields->relatedlinkimage2) ? $video->customFields->relatedlinkimage2 : lang('related-link-icon-2'); ?>" alt=""></a>
                                            </td> 
                                            <td>
                                                &nbsp;<a href="<?php echo $video->customFields->relatedlink2; ?>" target="_blank"><?php echo isset($video->customFields->relatedlinktext2) ? $video->customFields->relatedlinktext2 : $video->customFields->relatedlink2; ?> &raquo;</a>
                                            </td> 
                                        </tr>
                                    </table>
				</li>
			<?php } ?>
			<?php if(isset($video->customFields->relatedlink3)) { ?>
				<li>
                                    <table>
                                        <tr>
                                            <td>  
                                                <a href="<?php echo $video->customFields->relatedlink3; ?>" target="_blank">
                                                <img src="<?php echo isset($video->customFields->relatedlinkimage3) ? $video->customFields->relatedlinkimage3 : lang('related-link-icon-3'); ?>" alt=""></a>
                                            </td> 
                                            <td>
                                                &nbsp;<a href="<?php echo $video->customFields->relatedlink3; ?>" target="_blank"><?php echo isset($video->customFields->relatedlinktext3) ? $video->customFields->relatedlinktext3 : $video->customFields->relatedlink3; ?> &raquo;</a>
                                             </td> 
                                        </tr>
                                    </table>
                                 </li>
			<?php } ?>
		</ul>
