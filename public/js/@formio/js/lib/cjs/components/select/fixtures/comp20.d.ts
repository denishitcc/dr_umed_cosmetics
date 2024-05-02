declare namespace _default {
    let _id: string;
    let title: string;
    let name: string;
    let path: string;
    let type: string;
    let display: string;
    let components: ({
        label: string;
        widget: string;
        tableView: boolean;
        multiple: boolean;
        data: {
            values: {
                label: string;
                value: string;
            }[];
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
        multiple?: undefined;
        data?: undefined;
    })[];
    let project: string;
}
export default _default;
