<?php foreach ($messages_list as $row) { ?>	
    
    <li class="<?php echo $row['css']?>">
        <img src="<?php echo $row['image']?>" alt="" />
        <p><?php echo $row['message']?></p>
    </li>
<?php } ?>
<script>
    	var next_conversation_message_url =  '<?php echo $next_conversation_message_url ?>';
</script>