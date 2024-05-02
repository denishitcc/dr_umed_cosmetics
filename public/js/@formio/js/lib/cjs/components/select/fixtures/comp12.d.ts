declare namespace _default {
    let type: string;
    let components: ({
        label: string;
        tableView: boolean;
        dataSrc: string;
        data: {
            values: {
                label: string;
                value: string;
            }[];
            resource: string;
        };
        valueProperty: string;
        template: string;
        selectThreshold: number;
        validate: {
            onlyAvailableItems: boolean;
        };
        key: string;
        type: string;
        indexeddb: {
            filter: {};
        };
        searchField: string;
        input: boolean;
        addResource: boolean;
        reference: boolean;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        dataSrc?: undefined;
        data?: undefined;
        valueProperty?: undefined;
        template?: undefined;
        selectThreshold?: undefined;
        validate?: undefined;
        indexeddb?: undefined;
        searchField?: undefined;
        addResource?: undefined;
        reference?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
