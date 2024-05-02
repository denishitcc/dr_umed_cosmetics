declare namespace _default {
    let label: string;
    let reorder: boolean;
    let addAnotherPosition: string;
    let defaultOpen: boolean;
    let layoutFixed: boolean;
    let enableRowGroups: boolean;
    let initEmpty: boolean;
    let tableView: boolean;
    let modalEdit: boolean;
    let defaultValue: {
        textField: string;
        radio1: string;
        email: string;
    }[];
    let key: string;
    let type: string;
    let input: boolean;
    let components: ({
        label: string;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        mask?: undefined;
        spellcheck?: undefined;
        delimiter?: undefined;
        requireDecimal?: undefined;
        inputFormat?: undefined;
        optionsLabelPosition?: undefined;
        inline?: undefined;
        values?: undefined;
    } | {
        label: string;
        mask: boolean;
        spellcheck: boolean;
        tableView: boolean;
        delimiter: boolean;
        requireDecimal: boolean;
        inputFormat: string;
        key: string;
        type: string;
        input: boolean;
        optionsLabelPosition?: undefined;
        inline?: undefined;
        values?: undefined;
    } | {
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
        input: boolean;
        mask?: undefined;
        spellcheck?: undefined;
        delimiter?: undefined;
        requireDecimal?: undefined;
        inputFormat?: undefined;
    })[];
}
export default _default;
