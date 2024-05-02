declare namespace _default {
    export let input: boolean;
    export let tableView: boolean;
    export let inputType: string;
    export let inputMask: string;
    export let label: string;
    export let key: string;
    export let placeholder: string;
    export let prefix: string;
    export let suffix: string;
    export let defaultValue: string;
    let _protected: boolean;
    export { _protected as protected };
    export let persistent: boolean;
    export let clearOnHide: boolean;
    export namespace validate {
        let required: boolean;
        let multiple: string;
        let custom: string;
    }
    export namespace conditional {
        let show: string;
        let when: null;
        let eq: string;
    }
    export let type: string;
    export let requireDecimal: boolean;
    export let delimiter: boolean;
    export let tags: never[];
}
export default _default;
