    <!--<script src="/task/assets/js/jquery.nicescroll.min.js"></script>-->
    <script src="<?= base_url('assets/js/jquery.js'); ?>"></script>
    <script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/script.js'); ?>"></script>
    <script src="<?= base_url('assets/js/drag_drop.js'); ?>"></script>
    
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $(function () {
            $('[data-toggle="popover"]').popover()
        });
    </script>
    
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>
    <script src="<?= base_url('assets/js/team.js'); ?>"></script>
    <script src="<?= base_url('assets/js/task.js'); ?>"></script>

    <script>
        setAuthorId("<?= $author_id ?>");
    </script>
    
    </body>
</html> 