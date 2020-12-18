<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/Chart.bundle.js"></script>
<script src="assets/js/chart.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/js/html5shiv.min.js"></script>
<script src="assets/js/respond.min.js"></script>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/auto-load.js"></script>

<?php if ($payment_status == 0) { ?>
    <script>
        $('img').bind('contextmenu', function (e) {
            return false;
        });
    </script>
<?php } ?>