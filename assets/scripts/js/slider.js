class Slider {
    constructor ($slider_cntr) {
        const $content_cntr = $slider_cntr.querySelector('.content-cntr'),
            SCROLL_SIZE = +getComputedStyle($content_cntr.firstElementChild).width.slice(0, -2);

        $slider_cntr.querySelector('#SlideLeftBtn').onclick = () => $content_cntr.scrollLeft += -SCROLL_SIZE;
        $slider_cntr.querySelector('#SlideRightBtn').onclick = () => $content_cntr.scrollLeft += SCROLL_SIZE;
    }
}