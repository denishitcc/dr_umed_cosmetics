declare namespace _default {
    let title: string;
    let name: string;
    let path: string;
    let type: string;
    let display: string;
    let components: ({
        label: string;
        widget: string;
        tableView: boolean;
        dataSrc: string;
        data: {
            url: string;
            headers: {
                key: string;
                value: string;
            }[];
        };
        valueProperty: string;
        validateWhenHidden: boolean;
        key: string;
        type: string;
        input: boolean;
        defaultValue: string;
        selectValues: string;
        disableLimit: boolean;
        noRefreshOnScroll: boolean;
        selectData: {
            label: string;
        };
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        widget?: undefined;
        dataSrc?: undefined;
        data?: undefined;
        valueProperty?: undefined;
        validateWhenHidden?: undefined;
        defaultValue?: undefined;
        selectValues?: undefined;
        disableLimit?: undefined;
        noRefreshOnScroll?: undefined;
        selectData?: undefined;
    })[];
}
export default _default;
