declare namespace _default {
    let type: string;
    let components: ({
        label: string;
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
            components: ({
                label: string;
                mask: boolean;
                tableView: boolean;
                delimiter: boolean;
                requireDecimal: boolean;
                inputFormat: string;
                key: string;
                type: string;
                input: boolean;
                validate?: undefined;
                customConditional?: undefined;
            } | {
                label: string;
                tableView: boolean;
                validate: {
                    required: boolean;
                };
                key: string;
                customConditional: string;
                type: string;
                input: boolean;
                mask?: undefined;
                delimiter?: undefined;
                requireDecimal?: undefined;
                inputFormat?: undefined;
            })[];
        }[];
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        rowDrafts?: undefined;
        components?: undefined;
    })[];
    let title: string;
    let display: string;
}
export default _default;
