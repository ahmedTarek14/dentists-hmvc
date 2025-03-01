<script src="{{ aurl('js/core/popper.min.js') }}"></script>
<script src="{{ aurl('js/core/bootstrap.min.js') }}"></script>
<script src="{{ aurl('js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ aurl('js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="../assets/js/plugins/chartjs.min.js"></script>



<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ aurl('js/soft-ui-dashboard.min.js?v=1.1.0') }}"></script>
