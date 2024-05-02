declare namespace _default {
    let type: string;
    let components: ({
        label: string;
        tableView: boolean;
        data: {
            values: {
                label: string;
                value: string;
            }[];
        };
        selectThreshold: number;
        validate: {
            onlyAvailableItems: boolean;
        };
        key: string;
        type: string;
        indexeddb: {
            filter: {};
        };
        input: boolean;
        widget?: undefined;
        disableOnInvalid?: undefined;
    } | {
        label: string;
        widget: string;
        tableView: boolean;
        data: {
            values: {
                label: string;
                value: string;
            }[];
        };
        selectThreshold: number;
        validate: {
            onlyAvailableItems: boolean;
        };
        key: string;
        type: string;
        indexeddb: {
            filter: {};
        };
        input: boolean;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        data?: undefined;
        selectThreshold?: undefined;
        validate?: undefined;
        indexeddb?: undefined;
        widget?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
