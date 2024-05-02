declare namespace _default {
    let type: string;
    let components: ({
        type: string;
        label: string;
        key: string;
        dataSrc: string;
        data: {
            url: string;
        };
        valueProperty: string;
        template: string;
        input: boolean;
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
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
