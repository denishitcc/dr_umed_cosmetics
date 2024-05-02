declare namespace _default {
    export let input: boolean;
    export let tree: boolean;
    export let components: {
        type: string;
        label: string;
        key: string;
        input: boolean;
        components: {
            type: string;
            key: string;
            label: string;
            input: boolean;
        }[];
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
