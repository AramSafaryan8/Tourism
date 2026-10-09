class LazyAnim {
    #observer = null;
    #$trgt = null;

    constructor ($trgt, callback, options = {
        threshold: .5
    }) {
        if (!($trgt instanceof HTMLElement)) {
            throw new TypeError('The \'$trgt\' argument must be instance of HTMLElement.');
        }

        const CB_TYPE = typeof(callback);

        if (CB_TYPE != 'function') {
            throw new TypeError(`The ${CB_TYPE} is not a function.`);
        }

        this.#$trgt = $trgt;
        this.#observer = new IntersectionObserver(callback, options);
    }

    static applyToAll ($cntrs, trgtSelector) {
        $cntrs.forEach($cntr => {
            new LazyAnim($cntr, (entries, observer) => entries.forEach(entry => (.5 <= entry.intersectionRatio) && (
                entry.target.querySelectorAll(trgtSelector).forEach($meter => ($meter.classList.add('anim-fill'), observer.disconnect()))
            ))).perform();
        });
    }

    perform () {
        this.#observer.observe(this.#$trgt);
    }
}