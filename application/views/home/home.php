<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
				<img id="profile-img" src="http://emilcarlsson.se/assets/mikeross.png" class="online" alt="" />
				<p>Tuấn Đào</p>
				<i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
				<div id="status-options">
					<ul>
						<li id="status-online" class="active"><span class="status-circle"></span>
							<p>Online</p>
						</li>
						<li id="status-away"><span class="status-circle"></span>
							<p>Away</p>
						</li>
						<li id="status-busy"><span class="status-circle"></span>
							<p>Busy</p>
						</li>
						<li id="status-offline"><span class="status-circle"></span>
							<p>Offline</p>
						</li>
					</ul>
				</div>
				<div id="expanded">
					<label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="mikeross" />
					<label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="ross81" />
					<label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="mike.ross" />
				</div>
			</div>
		</div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" placeholder="Search contacts..." />
		</div>
		<input type="hidden" id="next_conversation_url" name="next_conversation_url" value="<?php echo $next_conversation_url ?>" />
		<div id="contacts" class="scroll-contact">
			<form action="<?php echo base_url() ?>" method="get" id="changeconversation">

				<input type="hidden" name="page_id" value="<?php echo $page_id ?>" />
				<input type="hidden" name="conversation_id" id="conversation_id" value="<?php echo $conversation_id ?>" />
			</form>
			<ul id="contact-list">

				<?php foreach ($conversation_list as $row) { ?>
					<li class="contact <?php if ($conversation_id == $row['id']) {
											echo "active";
										} ?>" data-id="<?php echo $row['id'] ?>">
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

			</ul>

		</div>
		<div id="bottom-bar">
			<button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
			<button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
		</div>
	</div>
	<div class="content">
		<div class="contact-profile">
			<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
			<p>Harvey Specter</p>
			<div class="social-media">
				<i class="fa fa-facebook" aria-hidden="true"></i>
				<i class="fa fa-twitter" aria-hidden="true"></i>
				<i class="fa fa-instagram" aria-hidden="true"></i>
			</div>
		</div>
		<div class="messages content-msg" id="content-message">
			<ul id="msg-list">
				<?php foreach ($messages_list as $row) { ?>

					<li class="<?php echo $row['css'] ?>">
						<img src="<?php echo $row['image'] ?>" alt="" />
						<p><?php echo $row['message'] ?></p>
					</li>
				<?php } ?>

			</ul>
		</div>
		<div class="message-input">
			<div class="wrap">
				<input type="text" placeholder="Write your message..." />
				<i class="fa fa-paperclip attachment" aria-hidden="true"></i>
				<button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</div>
<script>
	$(".messages").animate({
		scrollTop: $(document).height()
	}, "fast");

	$("#profile-img").click(function() {
		$("#status-options").toggleClass("active");
	});

	$(".expand-button").click(function() {
		$("#profile").toggleClass("expanded");
		$("#contacts").toggleClass("expanded");
	});

	$("#status-options ul li").click(function() {
		$("#profile-img").removeClass();
		$("#status-online").removeClass("active");
		$("#status-away").removeClass("active");
		$("#status-busy").removeClass("active");
		$("#status-offline").removeClass("active");
		$(this).addClass("active");

		if ($("#status-online").hasClass("active")) {
			$("#profile-img").addClass("online");
		} else if ($("#status-away").hasClass("active")) {
			$("#profile-img").addClass("away");
		} else if ($("#status-busy").hasClass("active")) {
			$("#profile-img").addClass("busy");
		} else if ($("#status-offline").hasClass("active")) {
			$("#profile-img").addClass("offline");
		} else {
			$("#profile-img").removeClass();
		};

		$("#status-options").removeClass("active");
	});

	function newMessage() {
		message = $(".message-input input").val();
		if ($.trim(message) == '') {
			return false;
		}
		$('<li class="replies"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
		$('.message-input input').val(null);
		$('.contact.active .preview').html('<span>You: </span>' + message);
		$(".messages").animate({
			scrollTop: $(document).height()
		}, "fast");
	};

	$('.submit').click(function() {
		newMessage();
	});

	$(window).on('keydown', function(e) {
		if (e.which == 13) {
			newMessage();
			return false;
		}
	});

	// facebook get converstation
	var next_conversation_url = '<?php echo $next_conversation_url ?>';
	var conversation_id = '<?php echo $conversation_id ?>';
	var page_id = '<?php echo $page_id ?>';
	var next_conversation_message_url = '<?php echo $next_conversation_message_url ?>';
	var send_load_more_msg = false;
	var send_load_more_conversation = false;


	function load_more_chat_message() {
		if (send_load_more_msg == false) {
			send_load_more_msg = true;
			$url = next_conversation_message_url;
			$.ajax({
				url: "<?php echo base_url() . "facebook/loadChatMessageConverstation" ?>",
				type: "get",
				data: {
					url: $url,
					conversation_id: conversation_id,
					page_id: page_id,
				},
				beforeSend: function(xhr) {
					//	$("#msg-list").after($("<li class='loading'>Loading...</li>").fadeIn('slow')).data("loading", true);
				},
				success: function(data) {
					send_load_more_msg = false;

					var $results = $("#msg-list");
					$(".loading").fadeOut('fast', function() {
						$(this).remove();
					});
					$results.prepend(data);
					$results.removeData("loading");

				}
			});
		}

	}

	function load_more_conversations() {
		$url = next_conversation_url;
		if (send_load_more_conversation == false) {
			send_load_more_conversation = true;
			if ($url != '') {
				$.ajax({
					url: "<?php echo base_url() . "facebook/loadMoreConversation" ?>",
					type: "get",
					data: {
						url: $url,
						page_id: page_id,
					},
					beforeSend: function(xhr) {
						//	$("#contact-list").after($("<li class='loading'>Loading...</li>").fadeIn('slow')).data("loading", true);
					},
					success: function(data) {
						send_load_more_conversation = false;
						var $results = $("#contact-list");
						$(".loading").fadeOut('fast', function() {
							$(this).remove();
						});
						$results.append(data);
						$results.removeData("loading");
					}
				});
			} else {
				$results.removeData("loading");
			}

		}

	}
	$(function() {

		var objDiv = document.getElementById("content-message");
		objDiv.scrollTop = objDiv.scrollHeight;


		// load new convertion selected
		$("#contact-list li").click(function() {
			var conversation_select_id = $(this).attr("data-id");			
			$("#conversation_id").val(conversation_select_id);
			$("#changeconversation").submit();
			
		});
		$(".scroll-contact").scroll(function() {
			var $this = $(this);
			var $results = $("#contact-list");
			if (!$results.data("loading")) {
				if ($this.scrollTop() + $this.height() >= $results.height() - 100) {
					load_more_conversations();
				}

			}
		});

		$("#content-message").scroll(function() {
			var $this = $(this);
			if ($this.scrollTop() < 200) {
				load_more_chat_message();
			}
		});


	});

	//# sourceURL=pen.js
</script>