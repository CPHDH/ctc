<div class="flex-2">
	<div class="col <?php echo (count($docs)>0) ? 'has-docs' : null;?>">
	    <div id="item-files">
	    	<?php if(count($files)>0 || count($docs)>0){
				echo get_img_files($item); // image files
				echo get_streaming_files($item); // audio and video
				if(count($docs)>0){
					foreach($docs as $d){
						echo file_markup($d); // "documents" (will use PDF Embed plugin if active)
					}
				}		    
		    }?>	
	    </div>    
	</div>
	
	<div class="col">   
		 
	 	<div class="description">
			<?php echo the_description($item);?>
		</div>   
		
<!--
	    <div id="item-citation" class="element">
	        <?php echo '~ '.metadata('item','citation',array('no_escape'=>true)); ?>
	    </div>	
-->
	    
	</div>    
	
</div>