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

    const financeourconsulting = new SplitType("#finance-ourconsulting");
    gsap.to("#finance-ourconsulting .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#finance-ourconsulting",
            start: "top 90%",
            end: "top 60%",
            scrub: true
        }
    })
    

    gsap.from("#finance-advice-text", {
        ease: "power2.out",
        x: "100%",
        scrollTrigger: {
            trigger: "#finance-advice-text",
            start: "center 80%",
            end: "center 80%",
        }
    })

    gsap.from("#finance-advice-img", {
        ease: "power2.out",
        x: "100%",
        delay: 0.5,
        scrollTrigger: {
            trigger: "#finance-advice-img",
            start: "center 80%",
            end: "center 80%",
        }
    })

    
    gsap.from("#finance-winning-text", {
        ease: "power2.out",
        x: "-100%",
        delay: 0.5,
        scrollTrigger: {
            trigger: "#finance-winning-text",
            start: "center 80%",
            end: "center 80%",

        }
    })

    gsap.from("#finance-winning-img", {
        ease: "power2.out",
        x: "-100%",
        scrollTrigger: {
            trigger: "#finance-winning-img",
            start: "center 80%",
            end: "center 80%",
        }
    })

    const financeconsultingtext = new SplitType("#g-financeconsultingtext");
    gsap.to("#g-financeconsultingtext .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-financeconsultingtext",
            start: "top 80%",
            end: "top 60%",
            scrub: true
        }
    })


    gsap.from("#g-financeconsultingimg", {
        ease: "power2.out",
        x: "100%",
        scrollTrigger: {
            trigger: "#g-financeconsultingimg",
            start: "center 80%",
            end: "center 50%",
            scrub: true,
        }
    })


</script>