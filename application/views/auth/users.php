<table class="table">
	<th>Username</th>
	<th>Email</th>
	<th>Last seen</th>
	<?php foreach($users as $user): ?>
		<tr>
			<td><a href="#" onclick="chatWithUser()"><?php echo $user->username; ?></a></td>
			<td><?php echo $user->user_email; ?></td>
			<td><?php echo $user->user_last_login; ?></td>
		</tr>
	<?php endforeach; ?>
</table>