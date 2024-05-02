declare namespace _default {
    let type: string;
    let components: ({
        label: string;
        openWhenEmpty: boolean;
        tableView: boolean;
        rowDrafts: boolean;
        key: string;
        type: string;
        input: boolean;
        components: {
            label: string;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
        }[];
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        openWhenEmpty?: undefined;
        rowDrafts?: undefined;
        components?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
}
export default _default;
