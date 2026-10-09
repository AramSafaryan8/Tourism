class Validation {
    static #types = {
        CCNumber: /[\w\s]{0}\d{1,4}(-\d{1,4}){0,3}/
    };
    static #functions = {
        CCNumber: {
            fixLength (input) { return (input.replaceAll('-', '').length > 16) ? input.slice(0, 19) : input; },
            fixFragmentation (input) {
                const INPUT_RAW = input.replaceAll('-', ''), LENGTH_RAW = INPUT_RAW.length;

                let result = '';

                for (var i = 4; i < LENGTH_RAW; i += 4) {
                    result += `${INPUT_RAW.slice(i - 4, i)}-`;
                }

                return `${result}${INPUT_RAW.slice(result.replaceAll('-', '').length - LENGTH_RAW)}${LENGTH_RAW == i && LENGTH_RAW != 16 ? '-' : ''}`;
            }
        }
    }
    #input = '';
    #inputFixed = '';
    #typeName = '';

    get input () {
        return this.#input;
    }

    get inputFixed () {
        return this.#inputFixed;
    }

    constructor (input, typeName) {
        if (typeof(this.#input) != 'string' || typeof(this.#typeName) != 'string') {
            throw new TypeError('The type of the arguments must be string.');
        }

        this.#input = input;
        this.#inputFixed = '';
        this.#typeName = typeName;

        (this.#input && this.#typeName) && this.perform();
    }

    fix (input) {
        if (typeof(input) != 'string') {
            throw new TypeError('The type of the argument must be string.');
        }

        const functions = Validation.#functions[this.#typeName];

        for (const name in functions) {
            input = functions[name](input);
        }

        return input;
    }

    perform (input = null) {
        if (typeof(input) != 'string' && null !== input) {
            throw new TypeError('The type of the argument must be string.');
        }

        if (!input) {
            return (this.#input = this.#inputFixed = input, true);
        }

        const match = input.match(Validation.#types[this.#typeName]);

        if (!(this.#typeName in Validation.#types) || !match) {
            return false;
        }

        this.#inputFixed = match[0];

        this.#inputFixed = this.fix(this.#inputFixed);

        return (this.#input = this.#inputFixed, true);
    }

    setTypeName (value) {
        if (typeof(value) != 'string') {
            throw new TypeError('The type of the argument must be string.');
        }

        this.#typeName = value;
    }
}