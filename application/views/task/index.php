<!DOCTYPE html>
<html>
<head>
	<title>Tasks</title>
</head>
<body>
	My tasks

	<?php foreach ($tasks as $task): ?>
		<div>
			<?= $task->title ?>
			<?= $task->description ?>
			<?= $task->due_date ?>
			<a href="<?= base_url('tasks/done/' . $task->id) ?>">Mark as Done</a>
			<div>
				<?php foreach ($task->notes as $note): ?>
					<div>
						<?= $note->body ?>
					</div>
				<?php endforeach; ?>

				<form method="POST" action="<?= base_url('tasks/' . $task->id . '/notes/create') ?>">
					<textarea name="body" placeholder="body"></textarea>
					<input type="submit" value="Create Note" />
				</form>
			</div>
		</div>
	<?php endforeach; ?>
</body>
</html>