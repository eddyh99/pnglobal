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

    
    gsap.from("#g-international-expansionimg", {
        ease: "power2.out",
        x: "100%",
        scrollTrigger: {
            trigger: "#g-international-expansionimg",
            start: "center 80%",
            end: "center 50%",
            scrub: true
        }
    });
    
    gsap.from("#g-international-visaimg", {
        ease: "power2.out",
        x: "-100%",
        scrollTrigger: {
            trigger: "#g-international-visaimg",
            start: "center 80%",
            end: "center 50%",
            scrub: true
        }
    });
    
    gsap.from("#g-international-offshoreimg", {
        ease: "power2.out",
        x: "100%",
        scrollTrigger: {
            trigger: "#g-international-offshoreimg",
            start: "center 80%",
            end: "center 50%",
            scrub: true
        }
    });

</script>