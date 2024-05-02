declare namespace _default {
    let label: string;
    let columns: ({
        components: {
            label: string;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
            hideOnChildrenHidden: boolean;
        }[];
        width: number;
        offset: number;
        push: number;
        pull: number;
        size: string;
        currentWidth: number;
    } | {
        components: {
            label: string;
            mask: boolean;
            tableView: boolean;
            delimiter: boolean;
            requireDecimal: boolean;
            inputFormat: string;
            truncateMultipleSpaces: boolean;
            key: string;
            type: string;
            input: boolean;
            hideOnChildrenHidden: boolean;
        }[];
        width: number;
        offset: number;
        push: number;
        pull: number;
        size: string;
        currentWidth: number;
    })[];
    let modalEdit: boolean;
    let key: string;
    let type: string;
    let input: boolean;
    let tableView: boolean;
}
export default _default;
