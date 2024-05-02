declare namespace _default {
    let _id: string;
    let type: string;
    let components: ({
        label: string;
        widget: string;
        tableView: boolean;
        dataSrc: string;
        valueProperty: string;
        data: {
            custom: string;
        };
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
        widget?: undefined;
        dataSrc?: undefined;
        valueProperty?: undefined;
        data?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
