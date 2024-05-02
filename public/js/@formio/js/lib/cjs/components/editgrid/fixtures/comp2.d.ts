declare namespace _default {
    export let components: {
        components: ({
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
            customDefaultValue: string;
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
            properties?: undefined;
            tags?: undefined;
        } | {
            properties: {
                '': string;
            };
            tags: never[];
            type: string;
            conditional: {
                show: string;
                when: string;
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
            customDefaultValue?: undefined;
        })[];
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
    export let tags: never[];
    export let type: string;
    export namespace templates {
        let header: string;
        let row: string;
        let footer: string;
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
