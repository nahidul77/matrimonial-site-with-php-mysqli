<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/jquery.pogo-slider.min.js"></script>
<script src="js/custom.js"></script>

<script>
        $('img').bind('contextmenu', function (e) {
            return false;
        });
        
        
  document.onkeyup = function(e) {
      
  if (e.ctrlKey && e.altKey && e.which == 65) {
    window.location = "../login/admin/";
  }
};
        
        
</script>