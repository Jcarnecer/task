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
			</form>
			<div>
				<?php foreach ($task->tags as $tag): ?>
					<div>
						<?= $tag->name ?> <form method="POST" action="<?=base_url('tasks/' . $task->id . '/tags/del') ?>">
						<input type="hidden" name="name" value="<?= $tag->name ?>">
						<input type="submit" value="x"/></form>
					</div>
				<?php endforeach; ?>

				<form method="POST" action="<?= base_url('tasks/' . $task->id . '/tags/add' ) ?>">
					<textarea name="name" placeholder="body" required></textarea>
					<input type="submit" value="Add Tag" />
				</form>

				<?php foreach ($task->notes as $note): ?>
					<div>
						<?= $note->body ?>
					</div>
				<?php endforeach; ?>

				<form method="POST" action="<?= base_url('tasks/' . $task->id . '/notes/create') ?>">
					<textarea name="body" placeholder="body" reuired></textarea>
					<input type="submit" value="Create Note" />
				</form>
			</div>
		</div>
		<hr>
	<?php endforeach; ?>
</body>
</html>