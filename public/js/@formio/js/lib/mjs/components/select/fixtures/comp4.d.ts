declare namespace _default {
    export let label: string;
    export let labelPosition: string;
    export let widget: string;
    export let tableView: boolean;
    export let modalEdit: boolean;
    export let multiple: boolean;
    export let dataSrc: string;
    export namespace data {
        let values: {
            label: string;
            value: string;
        }[];
        let resource: string;
        let json: string;
        let url: string;
        let custom: string;
    }
    export let valueProperty: string;
    export let dataType: string;
    export let template: string;
    export let searchEnabled: boolean;
    export let selectThreshold: number;
    export let readOnlyValue: boolean;
    export let customOptions: {};
    export let persistent: boolean;
    let _protected: boolean;
    export { _protected as protected };
    export let dbIndex: boolean;
    export let encrypted: boolean;
    export let clearOnHide: boolean;
    export let customDefaultValue: string;
    export let calculateValue: string;
    export let calculateServer: boolean;
    export let allowCalculateOverride: boolean;
    export let validateOn: string;
    export namespace validate {
        export let required: boolean;
        export let customMessage: string;
        let custom_1: string;
        export { custom_1 as custom };
        export let customPrivate: boolean;
        let json_1: string;
        export { json_1 as json };
        export let strictDateValidation: boolean;
        let multiple_1: boolean;
        export { multiple_1 as multiple };
        export let unique: boolean;
    }
    let unique_1: boolean;
    export { unique_1 as unique };
    export let errorLabel: string;
    export let key: string;
    export let tags: never[];
    export let properties: {};
    export namespace conditional {
        export let show: null;
        export let when: null;
        export let eq: string;
        let json_2: string;
        export { json_2 as json };
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
    export namespace indexeddb {
        let filter: {};
    }
    export let selectFields: string;
    export let searchField: string;
    export let minSearch: number;
    let filter_1: string;
    export { filter_1 as filter };
    export let limit: number;
    export let refreshOn: string;
    export let redrawOn: string;
    export let input: boolean;
    export let prefix: string;
    export let suffix: string;
    export let showCharCount: boolean;
    export let showWordCount: boolean;
    export let allowMultipleMasks: boolean;
    export let clearOnRefresh: boolean;
    export let lazyLoad: boolean;
    export let authenticate: boolean;
    export let searchThreshold: number;
    export namespace fuseOptions {
        let include: string;
        let threshold: number;
    }
    export let id: string;
    export let defaultValue: string;
}
export default _default;
