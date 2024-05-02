declare namespace _default {
    let title: string;
    let name: string;
    let path: string;
    let type: string;
    let display: string;
    let components: ({
        label: string;
        optionsLabelPosition: string;
        inline: boolean;
        tableView: boolean;
        values: {
            label: string;
            value: string;
            shortcut: string;
        }[];
        key: string;
        type: string;
        dataType: string;
        input: boolean;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        optionsLabelPosition?: undefined;
        inline?: undefined;
        values?: undefined;
        dataType?: undefined;
    })[];
}
export default _default;
