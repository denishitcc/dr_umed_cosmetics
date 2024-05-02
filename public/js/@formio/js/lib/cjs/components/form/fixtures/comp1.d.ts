declare namespace _default {
    let key: string;
    let input: boolean;
    let tableView: boolean;
    let components: {
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
        clearOnHide: boolean;
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
    let type: string;
    let tags: never[];
    namespace conditional {
        let show: string;
        let when: null;
        let eq: string;
    }
}
export default _default;
