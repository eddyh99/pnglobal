<script>
    gsap.registerPlugin(ScrollTrigger);

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