declare namespace _default {
    let type: string;
    let components: ({
        label: string;
        dataSrc: string;
        data: {
            url: string;
        };
        valueProperty: string;
        template: string;
        key: string;
        type: string;
        input: boolean;
        inputType: string;
        showValidations?: undefined;
        alwaysEnabled?: undefined;
        tableView?: undefined;
    } | {
        label: string;
        showValidations: boolean;
        alwaysEnabled: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        dataSrc?: undefined;
        data?: undefined;
        valueProperty?: undefined;
        template?: undefined;
        inputType?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
