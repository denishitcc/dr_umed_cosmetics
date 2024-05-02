declare namespace _default {
    let _id: string;
    let type: string;
    let components: ({
        label: string;
        widget: string;
        tableView: boolean;
        dataSrc: string;
        data: {
            resource: string;
            project: string;
        };
        dataType: string;
        valueProperty: string;
        template: string;
        validate: {
            select: boolean;
        };
        key: string;
        type: string;
        searchField: string;
        input: boolean;
        addResource: boolean;
        reference: boolean;
        showValidations?: undefined;
    } | {
        label: string;
        showValidations: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        widget?: undefined;
        dataSrc?: undefined;
        data?: undefined;
        dataType?: undefined;
        valueProperty?: undefined;
        template?: undefined;
        validate?: undefined;
        searchField?: undefined;
        addResource?: undefined;
        reference?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
    let project: string;
}
export default _default;
