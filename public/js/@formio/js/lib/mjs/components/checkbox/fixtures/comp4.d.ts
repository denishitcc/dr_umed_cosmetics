declare namespace _default {
    let title: string;
    let name: string;
    let path: string;
    let type: string;
    let display: string;
    let components: ({
        label: string;
        inputType: string;
        tableView: boolean;
        key: string;
        type: string;
        name: string;
        value: string;
        input: boolean;
        html?: undefined;
        refreshOnChange?: undefined;
        customConditional?: undefined;
        disableOnInvalid?: undefined;
    } | {
        html: string;
        label: string;
        refreshOnChange: boolean;
        key: string;
        type: string;
        input: boolean;
        tableView: boolean;
        customConditional: string;
        inputType?: undefined;
        name?: undefined;
        value?: undefined;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        inputType?: undefined;
        name?: undefined;
        value?: undefined;
        html?: undefined;
        refreshOnChange?: undefined;
        customConditional?: undefined;
    })[];
}
export default _default;
