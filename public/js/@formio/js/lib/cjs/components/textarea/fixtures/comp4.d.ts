declare namespace _default {
    let type: string;
    let components: ({
        type: string;
        key: string;
        rows: number;
        editor: string;
        hideLabel: boolean;
        as: string;
        input: boolean;
        label?: undefined;
        showValidations?: undefined;
        tableView?: undefined;
    } | {
        label: string;
        showValidations: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        rows?: undefined;
        editor?: undefined;
        hideLabel?: undefined;
        as?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
}
export default _default;
