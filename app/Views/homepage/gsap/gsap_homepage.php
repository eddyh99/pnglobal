<script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.utils.toArray('.box-consulting-homepage').forEach((element, i) => {
        const tltrigger = gsap.timeline({
            scrollTrigger: {
                trigger: element,
                // markers: true,
                start: "top 70%",
                end: "top 30%",
            }
        })
        
        tltrigger.fromTo(element, {
            x: `${(i % 2 === 0) ? "-100%" : "100%"}`
        }, {
            x: 0,
            duration: 2
        })
    });

    gsap.from("#g-img-banner-homepage", {
        opacity: 0,
        duration: 2,
        ease: "power2.inOut",
        scrollTrigger: {
            trigger: "#g-img-banner-homepage",
            start: "top 80%",
            end: "top 60%",
        }
    })

    gsap.to("#g-text-banner-homepage .line-animation", {
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

    gsap.to("#g-logo-why-homepage.line-animation", {
        x: 0,
        opacity: 1,
        ease: "power1.inOut",
        stagger: 0.5,
        duration: 1,
        scrollTrigger: {
            trigger: "#g-logo-why-homepage",
            start: "top 100%",
            end: "top 0%",
        }
    })

    gsap.to("#g-title-why-homepage.line-animation", {
        y: 0,
        ease: "power1.inOut",
        stagger: 0.5,
        duration: 1,
        scrollTrigger: {
            trigger: "#g-title-why-homepage",
            start: "top 90%",
            end: "top 0%",
        }
    })


    gsap.to("#g-why-sub-innovation .line-animation", {
        y: 0,
        ease: "power1.inOut",
        stagger: 0.5,
        duration: 1,
        scrollTrigger: {
            trigger: "#g-why-sub-innovation",
            start: "top 90%",
            end: "top 0%",
        }
    })

    gsap.to("#g-why-content-innovation .line-animation", {
        y: 0,
        ease: "power1.out",
        stagger: 0.5,
        duration: 1,
        scrollTrigger: {
            trigger: "#g-why-content-innovation",
            start: "top 90%",
            end: "top 0%",
        }
    })

    gsap.to("#g-why-sub-reliability .line-animation", {
        y: 0,
        ease: "power1.inOut",
        stagger: 0.5,
        duration: 1,
        scrollTrigger: {
            trigger: "#g-why-sub-reliability",
            start: "top 90%",
            end: "top 0%",
        }
    })

    gsap.to("#g-why-content-reliability .line-animation", {
        y: 0,
        ease: "power1.out",
        stagger: 0.5,
        duration: 1,
        scrollTrigger: {
            trigger: "#g-why-content-reliability",
            start: "top 90%",
            end: "top 0%",
        }
    })
    gsap.to("#g-why-sub-competence .line-animation", {
        y: 0,
        ease: "power1.inOut",
        stagger: 0.5,
        duration: 1,
        scrollTrigger: {
            trigger: "#g-why-sub-competence",
            start: "top 90%",
            end: "top 0%",
        }
    })

    gsap.to("#g-why-content-competence .line-animation", {
        y: 0,
        ease: "power1.out",
        stagger: 0.5,
        duration: 1,
        scrollTrigger: {
            trigger: "#g-why-content-competence",
            start: "top 90%",
            end: "top 0%",
        }
    })

</script>