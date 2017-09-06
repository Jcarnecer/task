<pre>
MODELS
	Tasks
		id
		title
		details
		user_id
		due_date
		completion_date
		color
		status [1] Active [2] Archived
		created_at
		updated_at

	TasksNotes
		id
		task_id
		user_id
		created_at

	TasksTags
		task_id
		name

	Teams
		id
		name
		status [1] Active [2] Deleted
		created_at
		updated_at
		deleted_at

	TeamTasks
		id
		team_id
		due_date
		completion_date
		color
		status [1] Active [2] Archived
		created_at
		updated_at

	TeamTasksNotes
		id
		task_id
		user_id
		created_at

	TeamTasksTags
		task_id
		name