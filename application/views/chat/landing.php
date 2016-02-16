<div class="alert alert-success">
	<strong>Hello!</strong>
	To get started, accept invitation or send invitation to chat with a friend.
</div>
<div class="callout callout-warning">
	<h3 class="text-info">Accept invitation</h3>

	<form action="#" method="post" id="respond">
		<div class="input-group">
			<input type="text" id="code" name="code" class="form-control" placeholder="Enter invite code"/>
		<span class="input-group-btn">
			<button class="btn btn-primary">accept invite</button>
		</span>
		</div>
	</form>

</div>

<div class="callout callout-info">
	<h3 class="text-info">Invite friends to chat</h3>

	<form action="#" method="post" id="invite">
		<div class="input-group">
			<input type="email" id="email" name="email" class="form-control" placeholder="Enter email address"/>
		<span class="input-group-btn">
			<button class="btn btn-info">send invite</button>
		</span>
		</div>
	</form>
</div>

<script>
	$('#invite').submit(function(e){
		e.preventDefault();

		var fd = new FormData();

		var email = $('#email').val();

		fd.append('email', email);
		fd.append('data', event.target.result);
		$.ajax({
			type: 'POST',
			url: '<?php echo site_url('chat/sendInvite'); ?>',
			data: fd,
			processData: false,
			contentType: false
		}).done(function (data) {
			var json = JSON.parse(data);
			if(json.success==1){
				msg('success','Invitation sent!')
			}
			if(json.error==1){
				msg('danger','Error sending invite!');
			}

		});
	});

	$('#respond').submit(function(e){
		e.preventDefault();

		var fd = new FormData();

		var code = $('#code').val();

		fd.append('code', code);
		fd.append('data', event.target.result);
		$.ajax({
			type: 'POST',
			url: '<?php echo site_url('chat/acceptInvite'); ?>',
			data: fd,
			processData: false,
			contentType: false
		}).done(function (data) {
			var json = JSON.parse(data);
			if(json.success==1){
				msg('success','User has been added to friends list! Begin conversation :)')
			}
			if(json.error==1){
				msg('danger','Error! unable to process request');
			}

		});
	})
</script>