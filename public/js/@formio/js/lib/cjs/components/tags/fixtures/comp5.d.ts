declare namespace _default {
    let type: string;
    let display: string;
    let components: ({
        label: string;
        tableView: boolean;
        delimeter: string;
        storeas: string;
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
        delimeter?: undefined;
        storeas?: undefined;
    })[];
}
export default _default;
