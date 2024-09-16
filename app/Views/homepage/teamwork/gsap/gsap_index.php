<script>
    gsap.registerPlugin(ScrollTrigger);
    
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
</script>