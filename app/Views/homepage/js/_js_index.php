
<script>
    $("document").ready(function($){
        var nav = $('#navbar');

        $(window).scroll(function () {
            if ($(this).scrollTop() > 600) {
                nav.addClass("active");
            } else {
                nav.removeClass("active");
            }
        });
    });

    $(".openbtn").click(function () {
        $(this).toggleClass('active');
    });

   $(function() {
        $(window).scrollTop($('#<?= @$_GET['type'] ?>').offset().top);
    });

    




</script>