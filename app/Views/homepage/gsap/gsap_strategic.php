<script>
    gsap.registerPlugin(ScrollTrigger);

    // gsap.utils.toArray('.box-service').forEach((element, i) => {
    //     const tltrigger = gsap.timeline({
    //         scrollTrigger: {
    //             trigger: element,
    //             // markers: true,
    //             start: "top 80%",
    //             end: "top 30%",
    //             scrub: true,
    //         }
    //     })
        
    //     tltrigger.fromTo(element, {
    //         x: `${(i % 2 === 0) ? "-100%" : "100%"}`
    //     }, {
    //         x: 0
    //     })
    // });

    gsap.from(".banner-text-video", {
        x: "-100%",
        duration: 1,
        scrollTrigger: {
            trigger: "banner-text-video",
            start: "top 90%",
            end: "top 50%",
        }
    })

    gsap.from("#g-aid-reallocating-funds", {
        x: "-100%",
        duration: 1,
        scrollTrigger: {
            trigger: "#g-aid-reallocating-funds",
            start: "top 70%",
            end: "top 50%",
        }
    })

    gsap.from("#g-tax-regulatory", {
        x: "-100%",
        duration: 1,
        scrollTrigger: {
            trigger: "#g-tax-regulatory",
            start: "top 70%",
            end: "top 50%",
        }
    })

    gsap.from("#g-strategic-for-corproat", {
        x: "100%",
        duration: 1,
        scrollTrigger: {
            trigger: "#g-strategic-for-corproat",
            start: "top 70%",
            end: "top 50%",
        }
    })


    gsap.from("#g-international-tax-planning", {
        x: "100%",
        duration: 1,
        scrollTrigger: {
            trigger: "#g-international-tax-planning",
            start: "top 70%",
            end: "top 50%",
        }
    })


</script>