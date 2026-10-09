class Popup {
    #popup = { $: null, style: null, $indicator: null };
    #victim = { $: null, style: null };

    constructor ($indicators, $victim, $popup) {
        if (!$victim || !$popup) {
            return;
        }

        this.$indicators = $indicators;

        this.#popup.$ = $popup;
        this.#popup.style = this.#popup.$.style;

        this.#victim.$ = $victim;
        this.#victim.style = $victim.style;

        this.#popup.$.classList.add('popup');
        this.#victim.$.classList.add('popup-victim');

        this.#victim.$.parentElement.appendChild(this.#popup.$);

        if (($indicators instanceof Array) || ($indicators instanceof NodeList)) {
            $indicators.forEach($indicator => $indicator.addEventListener('click', () => (this.#popup.$indicator = $indicator, this.#open())));
        } else {
            $indicators.addEventListener('click', () => (this.#popup.$indicator = $indicators, this.#open()));
        }

        this.#popup.$.addEventListener('click', e => (e.target == this.#popup.$) && (this.#close()));
        this.#popup.$.addEventListener('transitionend', e => ('opacity' == e.propertyName && !e.target.classList.contains('active')) && (this.#popup.style.zIndex = 0, this.#victim.style.filter = 'none'));
        this.#popup.$.firstElementChild.lastElementChild.onclick = () => this.#close();
    }

    get $ () {
        return this.#popup.$;
    }

    get $indicator () {
        return this.#popup.$indicator;
    }

    #close () {
        this.#popup.$.classList.remove('active');

        this.#popup.style.opacity = 0;  
    }

    #open () {
        this.#popup.$.classList.add('active');

        this.#victim.style.filter = 'blur(3px)';
        this.#popup.style.zIndex = 2;
        this.#popup.style.opacity = 1;
    }
}