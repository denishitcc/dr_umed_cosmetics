declare namespace _default {
    export namespace conditional {
        let eq: string;
        let when: null;
        let show: string;
    }
    export let tags: never[];
    export let type: string;
    export namespace validate {
        let custom: string;
    }
    export let clearOnHide: boolean;
    export let persistent: boolean;
    let _protected: boolean;
    export { _protected as protected };
    export let dayFirst: boolean;
    export namespace fields {
        namespace year {
            export let required: boolean;
            export let placeholder: string;
            let type_1: string;
            export { type_1 as type };
        }
        namespace month {
            let required_1: boolean;
            export { required_1 as required };
            let placeholder_1: string;
            export { placeholder_1 as placeholder };
            let type_2: string;
            export { type_2 as type };
        }
        namespace day {
            let required_2: boolean;
            export { required_2 as required };
            let placeholder_2: string;
            export { placeholder_2 as placeholder };
            let type_3: string;
            export { type_3 as type };
        }
    }
    export let key: string;
    export let label: string;
    export let tableView: boolean;
    export let input: boolean;
}
export default _default;
