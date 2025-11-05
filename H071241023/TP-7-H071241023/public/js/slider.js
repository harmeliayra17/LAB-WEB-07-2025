document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-slider]").forEach((btn) => {
        btn.addEventListener("click", () => {
            const track = document.querySelector(btn.dataset.slider);
            if (!track) return;
            const dir = parseInt(btn.dataset.dir, 10) || 1;
            const styles = getComputedStyle(track);
            const gap = parseFloat(styles.columnGap || styles.gap) || 16;
            const firstCard = track.querySelector(".snap-start");
            const step = firstCard
                ? firstCard.getBoundingClientRect().width + gap
                : track.clientWidth * 0.8;
            track.scrollBy({ left: dir * step, behavior: "smooth" });
        });
    });
    
    document.querySelectorAll("[data-target]").forEach((btn) => {
        btn.addEventListener("click", () => {
            const target = document.getElementById(btn.dataset.target);
            if (target) target.scrollIntoView({ behavior: "smooth", block: "start" });
        });
    });
});