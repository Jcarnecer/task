<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://bootswatch.com/darkly/bootstrap.min.css" />
</head>
<body>
	<div class="container">
		<form method="POST">
			<div>
				<label>Title</label>
				<input type="text" name="title" placeholder="Title" />
			</div>
			<div>
				<label>Description</label>
				<textarea name="description" placeholder="Description"></textarea>
			</div>
			<div>
				<label>Due Date</label>
				<input type="date" name="due_date" value="<?php echo date('Y-m-d'); ?>" />
			</div>
			<div>
				<label>Color</label>
				<input type="text" name="color" id="task-color" />
			</div>
			<div>
				<input type="submit" value="Create" />
			</div>
		</form>
	</div>
	<script src="/task/node_modules/jquery/dist/jquery.min.js"></script>
	<script>
		$(function () {

			$(document).on('input', '#task-color', function () {
				$(this).closest('.container').css('background-color', '#'+$(this).val());
			});

		});
	</script>

</body>
</html>