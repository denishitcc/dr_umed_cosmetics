declare namespace _default {
    let type: string;
    let components: ({
        label: string;
        tableView: boolean;
        rowDrafts: boolean;
        key: string;
        type: string;
        input: boolean;
        components: ({
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
        })[];
        showValidations?: undefined;
    } | {
        label: string;
        showValidations: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        rowDrafts?: undefined;
        components?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
