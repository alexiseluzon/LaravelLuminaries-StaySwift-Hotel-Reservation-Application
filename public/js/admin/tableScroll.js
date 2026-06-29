document.addEventListener('DOMContentLoaded', function () {
    const scrollContainer = document.querySelector('.ux-data-table');
    const thead = document.querySelector('thead');

    if (!scrollContainer || !thead) return;

    scrollContainer.addEventListener('scroll', function () {
        const topOfDiv = Math.max(scrollContainer.scrollTop - 2, 0);
        thead.style.top = topOfDiv + 'px';
    });
});