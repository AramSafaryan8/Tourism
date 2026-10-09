{
    const $sliders = document.querySelectorAll(".slider-cntr");

    const animateCharts = () => {
            const $charts = document.querySelectorAll('#Chart');

            ($charts.length) && LazyAnim.applyToAll($charts, 'tbody > tr > td > meter');
        }
        ,animateSliders = () => $sliders.forEach($slider_cntr => new Slider($slider_cntr))
        ,setMainPostCntrHeight = () => {
            const $mainPostCntr = document.getElementById('MainPostCntr');
            
            ($mainPostCntr) && ($mainPostCntr.style.height = `calc(100vh - ${document.querySelector('.main > header').offsetHeight}px)`);
        }
        ,setScrollbarWidth = () => document.documentElement.style.setProperty('--scrollbar-width', (window.innerWidth - document.documentElement.clientWidth) + "px")
        ,setUpBooking = () => {
            var bookingPopup = null, $cc = null, ccNumberValidator = null;
        
            if (document.querySelector('#Booking.popup')) {
                bookingPopup = new Popup(document.querySelectorAll('.btn.ticket'), document.body.firstElementChild, document.querySelector('#Booking.popup'));
        
                const $popupForm = bookingPopup.$.querySelector('#PopupForm');
        
                $popupForm.onsubmit = e => {
                    e.preventDefault();

                    const fd = new FormData($popupForm);

                    fd.append('tourId', +bookingPopup.$indicator.dataset.id);
        
                    fetch('/Tourism/booking', {
                        method: 'post',
                        body: fd
                    }).then(data => data.json()).then(resp => {
                        if ('reason' in resp) {
                            const $errCntr = $popupForm.querySelector('.err-cntr'),
                                component = new DOMParser().parseFromString(resp.data, 'text/html').body.firstElementChild,
                                $heading = component.querySelector('h1');

                            $heading.outerHTML = $heading.outerHTML.replaceAll('h1', 'h2');

                            (2 < $errCntr.childElementCount) && ($errCntr.children.item(1).remove());

                            $errCntr.insertBefore(component, $errCntr.lastElementChild)

                            return;
                        }

                        console.log(resp);

                        location.reload();
                    });
                };
        
                $cc = $popupForm.querySelector('#CCNumber');
        
                ccNumberValidator = new Validation('', 'CCNumber');
            
                ccNumberValidator.setTypeName('CCNumber');
            
                ($cc) && ($cc.oninput = e => {
                    const INPUT = e.target.value;

                    e.target.value = (e.inputType.startsWith('deleteContent')) ? ccNumberValidator.fix(INPUT) : ccNumberValidator.perform(INPUT) ? ccNumberValidator.inputFixed : ccNumberValidator.input;
                });
            }
        }
        ,setUpSliders = () => {
            let contentCntrArr = Array($sliders.length), $content_cntr = null;
            
            $sliders.forEach(($slider, i) => {
                contentCntrArr[i] = ($content_cntr = $slider.querySelector('.content-cntr'));
                
                Array.from($content_cntr.children).forEach($item => {
                    const $pic = $item.querySelector('.pic'), $hr_classList = $item.children.item(0).classList, $name_style = $item.querySelector('.name').style;
                    
                    $pic.addEventListener('mouseover', e => void(($hr_classList.add('active'), $name_style.opacity = 1)));
                    $pic.addEventListener('mouseout', e => void(($hr_classList.remove('active'), $name_style.opacity = 0)));
                })
            });
        };

    setScrollbarWidth();
    setMainPostCntrHeight();
    setUpBooking();
    setUpSliders();
    animateSliders();
    animateCharts();

    window.addEventListener('resize', e => void(setScrollbarWidth()));
    window.addEventListener('resize', e => void((animateSliders())));
}