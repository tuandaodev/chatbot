<script>
    var next_conversation_url = '<?php echo $next_conversation_url ?>';
</script>
<?php foreach($conversation_list as $row){ ?>
    <li class="contact" data-id ="<?php echo $row['id'] ?>">
        <div class="wrap">
            <!--<span class="contact-status online"></span> -->
            <img src="<?php echo $row['image'] ?>" alt="" />
            <div class="meta">
                <p class="name"><?php echo ($row['sender']) ?></p>
            <!--	<p class="preview">Will update later.</p> -->
            </div>
        </div>
    </li>
<?php } ?>

