declare namespace _default {
    export let input: boolean;
    export let tree: boolean;
    export let components: {
        input: boolean;
        tableView: boolean;
        inputType: string;
        inputMask: string;
        label: string;
        key: string;
        placeholder: string;
        prefix: string;
        suffix: string;
        multiple: boolean;
        defaultValue: string;
        protected: boolean;
        unique: boolean;
        persistent: boolean;
        validate: {
            required: boolean;
            minLength: string;
            maxLength: string;
            pattern: string;
            custom: string;
            customPrivate: boolean;
        };
        conditional: {
            show: string;
            when: null;
            eq: string;
        };
        type: string;
        tags: never[];
    }[];
    export let tableView: boolean;
    export let label: string;
    export let key: string;
    let _protected: boolean;
    export { _protected as protected };
    export let persistent: boolean;
    export let type: string;
    export let tags: never[];
    export namespace conditional {
        let show: string;
        let when: null;
        let eq: string;
    }
}
export default _default;
