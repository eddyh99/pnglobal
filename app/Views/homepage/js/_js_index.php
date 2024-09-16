
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


    // GSAP General 
    gsap.to("#g-getintouch .line-animation", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-getintouch",
            start: "top 90%",
            end: "top 60%",
        }
    })

    gsap.to("#g-textgetintouch .line-animation", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-textgetintouch",
            start: "top 90%",
            end: "top 60%",
        }
    })
    
    gsap.to("#g-subgetintouch .line-animation", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-subgetintouch",
            start: "top 90%",
            end: "top 60%",
        }
    })

    




</script>