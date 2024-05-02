declare namespace _default {
    let type: string;
    let display: string;
    let components: ({
        label: string;
        description: string;
        tooltip: string;
        applyMaskOn: string;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        description?: undefined;
        tooltip?: undefined;
        applyMaskOn?: undefined;
    })[];
}
export default _default;
