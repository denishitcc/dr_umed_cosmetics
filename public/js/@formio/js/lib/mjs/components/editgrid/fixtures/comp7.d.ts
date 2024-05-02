declare namespace _default {
    export let label: string;
    export let tableView: boolean;
    export namespace validate {
        let custom: string;
        let required: boolean;
        let customPrivate: boolean;
        let strictDateValidation: boolean;
        let multiple: boolean;
        let unique: boolean;
    }
    export let rowDrafts: boolean;
    export let key: string;
    export let type: string;
    export let input: boolean;
    export let components: ({
        label: string;
        tableView: boolean;
        defaultValue: boolean;
        key: string;
        type: string;
        input: boolean;
        conditional?: undefined;
        title?: undefined;
        collapsible?: undefined;
        components?: undefined;
    } | {
        label: string;
        tableView: boolean;
        key: string;
        conditional: {
            show: boolean;
            when: string;
            eq: string;
        };
        type: string;
        input: boolean;
        defaultValue?: undefined;
        title?: undefined;
        collapsible?: undefined;
        components?: undefined;
    } | {
        title: string;
        collapsible: boolean;
        key: string;
        type: string;
        label: string;
        input: boolean;
        tableView: boolean;
        components: {
            label: string;
            tableView: boolean;
            key: string;
            conditional: {
                show: boolean;
                when: string;
                eq: string;
            };
            type: string;
            input: boolean;
        }[];
        defaultValue?: undefined;
        conditional?: undefined;
    })[];
    export let placeholder: string;
    export let prefix: string;
    export let customClass: string;
    export let suffix: string;
    let multiple_1: boolean;
    export { multiple_1 as multiple };
    export let defaultValue: null;
    let _protected: boolean;
    export { _protected as protected };
    let unique_1: boolean;
    export { unique_1 as unique };
    export let persistent: boolean;
    export let hidden: boolean;
    export let clearOnHide: boolean;
    export let refreshOn: string;
    export let redrawOn: string;
    export let modalEdit: boolean;
    export let labelPosition: string;
    export let description: string;
    export let errorLabel: string;
    export let tooltip: string;
    export let hideLabel: boolean;
    export let tabindex: string;
    export let disabled: boolean;
    export let autofocus: boolean;
    export let dbIndex: boolean;
    export let customDefaultValue: string;
    export let calculateValue: string;
    export let calculateServer: boolean;
    export let widget: null;
    export let attributes: {};
    export let validateOn: string;
    export namespace conditional {
        let show: null;
        let when: null;
        let eq: string;
    }
    export namespace overlay {
        let style: string;
        let left: string;
        let top: string;
        let width: string;
        let height: string;
    }
    export let allowCalculateOverride: boolean;
    export let encrypted: boolean;
    export let showCharCount: boolean;
    export let showWordCount: boolean;
    export let properties: {};
    export let allowMultipleMasks: boolean;
    export let tree: boolean;
    export let disableAddingRemovingRows: boolean;
    export let removeRow: string;
    export let defaultOpen: boolean;
    export let openWhenEmpty: boolean;
    export let modal: boolean;
    export let inlineEdit: boolean;
    export namespace templates {
        let header: string;
        let row: string;
        let footer: string;
    }
    export let id: string;
}
export default _default;
