<div class="flex-2">
	<div class="col <?php echo (count($docs)>0) ? 'has-docs' : null;?>">
	    <div id="item-files">
	    	<?php if(count($files)>0 || count($docs)>0){
				echo get_img_files($item,the_hyperlink($item,false)); // image files	    
		    }?>	
	    </div>    
	</div>
	
	<div class="col">   
		 
	 	<div class="description">
			<?php echo the_description($item);?>
		</div>   
		
		<div class="item-hyperlink">
			<?php echo the_hyperlink($item);?>
		</div>
		
<!--
	    <div id="item-citation" class="element">
	        <?php echo '~ '.metadata('item','citation',array('no_escape'=>true)); ?>
	    </div>	
-->
	    			    
	</div>    
	
</div>