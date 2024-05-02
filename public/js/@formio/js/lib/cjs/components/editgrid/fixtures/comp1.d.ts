declare namespace _default {
    export let components: {
        components: {
            properties: {
                '': string;
            };
            tags: never[];
            type: string;
            conditional: {
                show: string;
                when: null;
                eq: string;
            };
            validate: {
                required: boolean;
                minLength: string;
                maxLength: string;
                pattern: string;
                custom: string;
                customPrivate: boolean;
            };
            clearOnHide: boolean;
            hidden: boolean;
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
        }[];
        clearOnHide: boolean;
        key: string;
        input: boolean;
        title: string;
        theme: string;
        tableView: boolean;
        type: string;
        breadcrumb: string;
        tags: never[];
        conditional: {
            eq: string;
            when: null;
            show: string;
        };
        properties: {
            '': string;
        };
    }[];
    export namespace validate {
        let row: string;
    }
    export let properties: {
        '': string;
    };
    export namespace conditional {
        let show: string;
        let when: null;
        let eq: string;
    }
    export let tags: never[];
    export let type: string;
    export namespace templates {
        export let header: string;
        let row_1: string;
        export { row_1 as row };
        export let footer: string;
    }
    export let clearOnHide: boolean;
    export let hidden: boolean;
    export let persistent: boolean;
    let _protected: boolean;
    export { _protected as protected };
    export let key: string;
    export let label: string;
    export let tableView: boolean;
    export let multiple: boolean;
    export let tree: boolean;
    export let input: boolean;
    export let removeRow: string;
}
export default _default;
