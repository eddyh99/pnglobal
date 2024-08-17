<script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.utils.toArray('.box-service').forEach((element, i) => {
        const tltrigger = gsap.timeline({
            scrollTrigger: {
                trigger: element,
                start: "top 50%",
                end: "top 30%",
            }
        })
        
        tltrigger.fromTo(element, {
            x: `${(i % 2 === 0) ? "100%" : "-100%"}`,
            duration: 2,
        }, {
            x: 0,
            duration: 1,
        })
    });

    gsap.to("#finance-ourconsulting .line-animation", {
        y: 0,
        stagger: 0.5,
        duration: 0.5,
        ease: "none",
        scrollTrigger: {
            trigger: "#finance-ourconsulting",
            start: "top 90%",
            end: "top 50%",
        }
    })


    gsap.to("#g-financeconsultingimg.line-animation", {
        y: 0,
        stagger: 0.5,
        duration: 0.5,
        ease: "none",
        scrollTrigger: {
            trigger: "#g-financeconsultingimg",
            start: "top 90%",
            end: "top 50%",
        }
    })


    gsap.from(".banner-text-video", {
        x: "-100%",
        duration: 1,
        scrollTrigger: {
            trigger: "banner-text-video",
            start: "top 90%",
            end: "top 50%",
        }
    })


</script>