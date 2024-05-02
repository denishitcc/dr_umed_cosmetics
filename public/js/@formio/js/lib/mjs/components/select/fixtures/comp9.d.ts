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
        key: string;
        type: string;
        input: boolean;
        dataSrc?: undefined;
        data?: undefined;
        template?: undefined;
        refreshOn?: undefined;
        lazyLoad?: undefined;
        selectThreshold?: undefined;
        validate?: undefined;
        indexeddb?: undefined;
        disableLimit?: undefined;
        disableOnInvalid?: undefined;
    } | {
        label: string;
        tableView: boolean;
        dataSrc: string;
        data: {
            values: {
                label: string;
                value: string;
            }[];
            url: string;
            headers: {
                key: string;
                value: string;
            }[];
        };
        template: string;
        refreshOn: string;
        lazyLoad: boolean;
        selectThreshold: number;
        validate: {
            onlyAvailableItems: boolean;
        };
        key: string;
        type: string;
        indexeddb: {
            filter: {};
        };
        input: boolean;
        disableLimit: boolean;
        mask?: undefined;
        spellcheck?: undefined;
        delimiter?: undefined;
        requireDecimal?: undefined;
        inputFormat?: undefined;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        mask?: undefined;
        spellcheck?: undefined;
        delimiter?: undefined;
        requireDecimal?: undefined;
        inputFormat?: undefined;
        dataSrc?: undefined;
        data?: undefined;
        template?: undefined;
        refreshOn?: undefined;
        lazyLoad?: undefined;
        selectThreshold?: undefined;
        validate?: undefined;
        indexeddb?: undefined;
        disableLimit?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
    let project: string;
    let machineName: string;
}
export default _default;
