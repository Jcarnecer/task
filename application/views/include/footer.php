    </div>
</div>

<script src="<?= base_url('assets/js/jquery.js'); ?>"></script>
<script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/fontawesome-all.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/script.js'); ?>"></script>

<script src="<?= base_url('assets/js/api.js'); ?>"></script>
<script src="<?= base_url('assets/js/main.js'); ?>"></script>
<script src="<?= base_url('assets/js/drag_drop.js'); ?>"></script>
<script src="<?= base_url('assets/js/kanban.js'); ?>"></script>
<script src="<?= base_url('assets/js/project.js'); ?>"></script>
<script src="<?= base_url('assets/js/task.js'); ?>"></script>

<script>
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    
    $(document).ajaxComplete(function () {
        
        $('[data-toggle="popover"]').popover();
    });
</script>

<script>
    setAuthorId('<?= $author_id ?>');
    setUserId('<?= $user_id ?>');
    setTaskType('<?= $task_type ?>');
</script>

</body>
</html> 