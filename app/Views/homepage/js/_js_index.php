
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


    gsap.registerPlugin(ScrollTrigger);

    gsap.utils.toArray('.box-service').forEach((element, i) => {
        console.log(i);
        const tltrigger = gsap.timeline({
            scrollTrigger: {
                trigger: element,
                // markers: true,
                start: "top 80%",
                end: "top 30%",
                scrub: true,
            }
        })
        
        tltrigger.fromTo(element, {
            x: `${(i % 2 === 0) ? "-100%" : "100%"}`
        }, {
            x: 0
        })
    });;




</script>