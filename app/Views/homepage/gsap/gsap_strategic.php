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

    gsap.from("#g-strategicaidimg", {
        ease: "power2.out",
        x: "100%",
        scrollTrigger: {
            trigger: "#g-strategicaid",
            start: "center 80%",
            end: "center 50%",
            scrub: true
        }
    })

    const gstrategiccorporatetitle = new SplitType("#g-strategic-corporate-title");
    gsap.to("#g-strategic-corporate-title .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-strategic-corporate-title",
            start: "top 80%",
            end: "top 60%",
            scrub: true
        }
    })

    const gstrategiccorporatesub = new SplitType("#g-strategic-corporate-sub");
    gsap.to("#g-strategic-corporate-sub .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-strategic-corporate-sub",
            start: "top 80%",
            end: "top 60%",
            scrub: true
        }
    })

    const gstrategiccorporatetext = new SplitType("#g-strategic-corporate-text");
    gsap.to("#g-strategic-corporate-text .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-strategic-corporate-text",
            start: "top 80%",
            end: "top 60%",
            scrub: true
        }
    })

    const gstrategicplaningtitle = new SplitType("#g-strategic-planing-title");
    gsap.to("#g-strategic-planing-title .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-strategic-planing-title",
            start: "top 80%",
            end: "top 60%",
            scrub: true
        }
    })

    const gstrategicplaningsub = new SplitType("#g-strategic-planing-sub");
    gsap.to("#g-strategic-planing-sub .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-strategic-planing-sub",
            start: "top 80%",
            end: "top 60%",
            scrub: true
        }
    })


    const gstrategicplaningtext = new SplitType("#g-strategic-planing-text");
    gsap.to("#g-strategic-planing-text .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-strategic-planing-text",
            start: "top 80%",
            end: "top 60%",
            scrub: true
        }
    })


</script>