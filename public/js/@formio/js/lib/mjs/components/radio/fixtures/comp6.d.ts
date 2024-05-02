declare namespace _default {
    let type: string;
    let components: ({
        label: string;
        optionsLabelPosition: string;
        inline: boolean;
        tableView: boolean;
        values: {
            label: string;
            value: string;
        }[];
        validate: {
            onlyAvailableItems: boolean;
        };
        key: string;
        type: string;
        input: boolean;
        showValidations?: undefined;
        alwaysEnabled?: undefined;
    } | {
        label: string;
        showValidations: boolean;
        alwaysEnabled: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        optionsLabelPosition?: undefined;
        inline?: undefined;
        values?: undefined;
        validate?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
