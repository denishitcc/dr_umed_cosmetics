declare namespace _default {
    let type: string;
    let components: ({
        label: string;
        mask: boolean;
        spellcheck: boolean;
        tableView: boolean;
        delimiter: boolean;
        requireDecimal: boolean;
        inputFormat: string;
        validate: {
            min: number;
            max: number;
        };
        key: string;
        type: string;
        input: boolean;
        showValidations?: undefined;
    } | {
        label: string;
        showValidations: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        mask?: undefined;
        spellcheck?: undefined;
        delimiter?: undefined;
        requireDecimal?: undefined;
        inputFormat?: undefined;
        validate?: undefined;
    })[];
    let revisions: string;
    let _vid: number;
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
