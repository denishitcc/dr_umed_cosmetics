declare namespace _default {
    let label: string;
    let disableAddingRemovingRows: boolean;
    let addAnother: string;
    let addAnotherPosition: string;
    let removePlacement: string;
    let defaultOpen: boolean;
    let layoutFixed: boolean;
    let enableRowGroups: boolean;
    let mask: boolean;
    let tableView: boolean;
    let alwaysEnabled: boolean;
    let type: string;
    let input: boolean;
    let key: string;
    let components: ({
        label: string;
        allowMultipleMasks: boolean;
        showWordCount: boolean;
        showCharCount: boolean;
        tableView: boolean;
        alwaysEnabled: boolean;
        type: string;
        input: boolean;
        key: string;
        widget: {
            type: string;
        };
        row: string;
        mask?: undefined;
    } | {
        label: string;
        mask: boolean;
        tableView: boolean;
        alwaysEnabled: boolean;
        type: string;
        input: boolean;
        key: string;
        row: string;
        allowMultipleMasks?: undefined;
        showWordCount?: undefined;
        showCharCount?: undefined;
        widget?: undefined;
    })[];
    let encrypted: boolean;
    let defaultValue: {
        name: string;
        age: number;
    }[];
    namespace validate {
        let customMessage: string;
        let json: string;
    }
    namespace conditional {
        export let show: string;
        export let when: string;
        let json_1: string;
        export { json_1 as json };
    }
}
export default _default;
