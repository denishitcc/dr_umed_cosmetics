declare namespace _default {
    let title: string;
    let name: string;
    let path: string;
    let type: string;
    let display: string;
    let components: {
        collapsible: boolean;
        key: string;
        type: string;
        label: string;
        input: boolean;
        tableView: boolean;
        components: ({
            label: string;
            widget: string;
            tableView: boolean;
            data: {
                values: {
                    label: string;
                    value: string;
                }[];
            };
            key: string;
            type: string;
            input: boolean;
            calculateValue?: undefined;
            logic?: undefined;
            disableOnInvalid?: undefined;
        } | {
            label: string;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
            widget?: undefined;
            data?: undefined;
            calculateValue?: undefined;
            logic?: undefined;
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
            calculateValue: string;
            key: string;
            logic: {
                name: string;
                trigger: {
                    type: string;
                    javascript: string;
                };
                actions: {
                    name: string;
                    type: string;
                    property: {
                        label: string;
                        value: string;
                        type: string;
                    };
                    state: boolean;
                }[];
            }[];
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
            data?: undefined;
            calculateValue?: undefined;
            logic?: undefined;
        })[];
    }[];
}
export default _default;
