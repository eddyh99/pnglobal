<script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.to("#g-mobilesatoshi .line-animation", {
        y: 0,
        stagger: 0.5,
        duration: 0.5,
        ease: "none",
        scrollTrigger: {
            trigger: "#g-mobilesatoshi",
            start: "top 90%",
            end: "top 50%",
        }
    });

    gsap.to("#g-text-downloadapp .line-animation", {
        y: 0,
        ease: "power1.inOut",
        stagger: 0.5,
        duration: 1,
        scrollTrigger: {
            trigger: "#g-text-downloadapp",
            start: "top 100%",
            end: "top 0%",
        }
    })
</script>