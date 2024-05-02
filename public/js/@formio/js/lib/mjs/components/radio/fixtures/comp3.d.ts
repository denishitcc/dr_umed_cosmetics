declare namespace _default {
    export let label: string;
    export let labelPosition: string;
    export let optionsLabelPosition: string;
    export let description: string;
    export let tooltip: string;
    export let customClass: string;
    export let tabindex: string;
    export let inline: boolean;
    export let hidden: boolean;
    export let hideLabel: boolean;
    export let autofocus: boolean;
    export let disabled: boolean;
    export let tableView: boolean;
    export let modalEdit: boolean;
    export let values: {
        label: string;
        value: string;
        shortcut: string;
    }[];
    export let dataType: string;
    export let persistent: boolean;
    let _protected: boolean;
    export { _protected as protected };
    export let dbIndex: boolean;
    export let encrypted: boolean;
    export let redrawOn: string;
    export let clearOnHide: boolean;
    export let customDefaultValue: string;
    export let calculateValue: string;
    export let calculateServer: boolean;
    export let allowCalculateOverride: boolean;
    export namespace validate {
        let required: boolean;
        let customMessage: string;
        let custom: string;
        let customPrivate: boolean;
        let json: string;
        let strictDateValidation: boolean;
        let multiple: boolean;
        let unique: boolean;
    }
    export let errorLabel: string;
    export let key: string;
    export let tags: never[];
    export let properties: {};
    export namespace conditional {
        export let show: null;
        export let when: null;
        export let eq: string;
        let json_1: string;
        export { json_1 as json };
    }
    export let customConditional: string;
    export let logic: never[];
    export let attributes: {};
    export namespace overlay {
        let style: string;
        let page: string;
        let left: string;
        let top: string;
        let width: string;
        let height: string;
    }
    export let type: string;
    export let input: boolean;
    export let placeholder: string;
    export let prefix: string;
    export let suffix: string;
    let multiple_1: boolean;
    export { multiple_1 as multiple };
    let unique_1: boolean;
    export { unique_1 as unique };
    export let refreshOn: string;
    export let widget: null;
    export let validateOn: string;
    export let showCharCount: boolean;
    export let showWordCount: boolean;
    export let allowMultipleMasks: boolean;
    export let inputType: string;
    export let fieldSet: boolean;
    export let id: string;
    export let defaultValue: string;
}
export default _default;
