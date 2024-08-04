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
            x: `${(i % 2 === 0) ? "100%" : "-100%"}`
        }, {
            x: 0
        })
    });

    
    const gstrainingformaltitle = new SplitType("#g-training-formal-title");
    gsap.to("#g-training-formal-title .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-training-formal-title",
            start: "top 80%",
            end: "top 60%",
            scrub: true
        }
    })

    
    const gstrainingformalsub = new SplitType("#g-training-formal-sub");
    gsap.to("#g-training-formal-sub .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-training-formal-sub",
            start: "top 80%",
            end: "top 60%",
            scrub: true
        }
    })
    
    const gstrainingformaltext = new SplitType("#g-training-formal-text");
    gsap.to("#g-training-formal-text .line", {
        y: 0,
        stagger: 0.05,
        scrollTrigger: {
            trigger: "#g-training-formal-text",
            start: "top 80%",
            end: "top 60%",
            scrub: true
        }
    })


    gsap.from("#g-training-formal-img", {
        ease: "power2.out",
        x: "100%",
        scrollTrigger: {
            trigger: "#g-training-formal-img",
            start: "center 80%",
            end: "center 50%",
            scrub: true
        }
    });
    
    

</script>