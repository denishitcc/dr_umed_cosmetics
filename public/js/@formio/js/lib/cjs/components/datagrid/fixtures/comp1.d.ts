declare namespace _default {
    export namespace conditional {
        let eq: string;
        let when: null;
        let show: string;
    }
    export let tags: never[];
    export let type: string;
    export let persistent: boolean;
    let _protected: boolean;
    export { _protected as protected };
    export let key: string;
    export let label: string;
    export let tableView: boolean;
    export let components: ({
        tags: never[];
        hideLabel: boolean;
        type: string;
        conditional: {
            eq: string;
            when: null;
            show: string;
        };
        validate: {
            customPrivate: boolean;
            custom: string;
            pattern: string;
            maxLength: string;
            minLength: string;
            required: boolean;
            multiple?: undefined;
            integer?: undefined;
            step?: undefined;
            max?: undefined;
            min?: undefined;
        };
        persistent: boolean;
        unique: boolean;
        protected: boolean;
        defaultValue: string;
        multiple: boolean;
        suffix: string;
        prefix: string;
        placeholder: string;
        key: string;
        label: string;
        inputMask: string;
        inputType: string;
        tableView: boolean;
        input: boolean;
        delimiter?: undefined;
    } | {
        conditional: {
            eq: string;
            when: null;
            show: string;
        };
        tags: never[];
        hideLabel: boolean;
        type: string;
        validate: {
            custom: string;
            multiple: string;
            integer: string;
            step: string;
            max: string;
            min: string;
            required: boolean;
            customPrivate?: undefined;
            pattern?: undefined;
            maxLength?: undefined;
            minLength?: undefined;
        };
        persistent: boolean;
        protected: boolean;
        defaultValue: string;
        suffix: string;
        prefix: string;
        placeholder: string;
        key: string;
        label: string;
        inputType: string;
        delimiter: boolean;
        tableView: boolean;
        input: boolean;
        unique?: undefined;
        multiple?: undefined;
        inputMask?: undefined;
    })[];
    export let tree: boolean;
    export let input: boolean;
}
export default _default;
