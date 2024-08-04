
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


    const getintouch = new SplitType("#g-getintouch");
    const subgetintouch = new SplitType("#g-subgetintouch");
    const textgetintouch = new SplitType("#g-textgetintouch")
    gsap.to("#g-getintouch .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-getintouch",
            start: "top 90%",
            end: "top 60%",
            scrub: true
        }
    })

    gsap.to("#g-textgetintouch .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-textgetintouch",
            start: "top 90%",
            end: "top 60%",
            scrub: true
        }
    })
    
    gsap.to("#g-subgetintouch .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-subgetintouch",
            start: "top 90%",
            end: "top 60%",
            scrub: true
        }
    })
    
    // const textgetintouch = new SplitText("#g-textgetintouch", {
    //     type: "lines",
    // });

    // gsap.from(textgetintouch.lines, {
    //     duration: 0.5,
    //     opacity: 0,
    //     rotationX: -120, 
    //     force3D:true, 
    //     transformOrigin:"top center -50", 
    //     stagger: 1,
    //     scrollTrigger: {
    //         trigger: "#g-textgetintouch",
    //         start: "top 80%",
    //         end: "top 50%",
    //         scrub: true,
    //     }
    // });



</script>