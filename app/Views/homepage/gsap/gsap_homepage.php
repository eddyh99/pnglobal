<script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.utils.toArray('.box-service').forEach((element, i) => {
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
    });

    // const financeconsultingtext = new SplitType("#g-financeconsultingtext");
    gsap.from("#g-img-banner-homepage", {
        opacity: 0,
        duration: 2,
        ease: "power2.inOut",
        scrollTrigger: {
            trigger: "#g-img-banner-homepage",
            start: "top 80%",
            end: "top 60%",
            // scrub: true
        }
    })

    const textbannerhomepage = new SplitType("#g-text-banner-homepage");
    gsap.to("#g-text-banner-homepage .line", {
        y: 0,
        ease: "power1.inOut",
        stagger: 0.5,
        duration: 1,
        scrollTrigger: {
            trigger: "#g-text-banner-homepage",
            start: "top 100%",
            end: "top 0%",
        }
    })

</script>