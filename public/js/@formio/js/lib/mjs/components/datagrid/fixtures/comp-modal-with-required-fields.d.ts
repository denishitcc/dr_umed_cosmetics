declare namespace _default {
    let label: string;
    let reorder: boolean;
    let addAnotherPosition: string;
    let defaultOpen: boolean;
    let layoutFixed: boolean;
    let enableRowGroups: boolean;
    let initEmpty: boolean;
    let tableView: boolean;
    let modalEdit: boolean;
    let defaultValue: {}[];
    let key: string;
    let type: string;
    let input: boolean;
    let components: ({
        label: string;
        tableView: boolean;
        validate: {
            required: boolean;
        };
        key: string;
        type: string;
        input: boolean;
        autoExpand?: undefined;
    } | {
        label: string;
        autoExpand: boolean;
        tableView: boolean;
        validate: {
            required: boolean;
        };
        key: string;
        type: string;
        input: boolean;
    })[];
}
export default _default;
