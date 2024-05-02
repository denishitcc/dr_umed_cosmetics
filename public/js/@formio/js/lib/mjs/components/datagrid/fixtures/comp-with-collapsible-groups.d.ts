declare namespace _default {
    let type: string;
    let components: ({
        label: string;
        disableAddingRemovingRows: boolean;
        reorder: boolean;
        addAnotherPosition: string;
        layoutFixed: boolean;
        enableRowGroups: boolean;
        initEmpty: boolean;
        tableView: boolean;
        defaultValue: {
            textField: string;
            number: string;
        }[];
        key: string;
        type: string;
        rowGroups: {
            label: string;
            numberOfRows: number;
        }[];
        groupToggle: boolean;
        input: boolean;
        components: ({
            label: string;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
            mask?: undefined;
            delimiter?: undefined;
            requireDecimal?: undefined;
            inputFormat?: undefined;
            truncateMultipleSpaces?: undefined;
        } | {
            label: string;
            mask: boolean;
            tableView: boolean;
            delimiter: boolean;
            requireDecimal: boolean;
            inputFormat: string;
            truncateMultipleSpaces: boolean;
            key: string;
            type: string;
            input: boolean;
        })[];
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        disableAddingRemovingRows?: undefined;
        reorder?: undefined;
        addAnotherPosition?: undefined;
        layoutFixed?: undefined;
        enableRowGroups?: undefined;
        initEmpty?: undefined;
        defaultValue?: undefined;
        rowGroups?: undefined;
        groupToggle?: undefined;
        components?: undefined;
    })[];
    let _vid: number;
    let title: string;
    let display: string;
    let name: string;
    let path: string;
    let project: string;
    let created: string;
    let modified: string;
    let machineName: string;
}
export default _default;
