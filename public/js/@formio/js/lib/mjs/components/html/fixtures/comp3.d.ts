declare namespace _default {
    let type: string;
    let display: string;
    let components: ({
        label: string;
        applyMaskOn: string;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        attrs?: undefined;
        content?: undefined;
        refreshOnChange?: undefined;
        disableOnInvalid?: undefined;
    } | {
        label: string;
        attrs: {
            attr: string;
            value: string;
        }[];
        content: string;
        refreshOnChange: boolean;
        key: string;
        type: string;
        input: boolean;
        tableView: boolean;
        applyMaskOn?: undefined;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        applyMaskOn?: undefined;
        attrs?: undefined;
        content?: undefined;
        refreshOnChange?: undefined;
    })[];
}
export default _default;
