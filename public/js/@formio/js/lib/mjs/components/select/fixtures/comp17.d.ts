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
        noRefreshOnScroll: boolean;
        addResource: boolean;
        reference: boolean;
        input: boolean;
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
        noRefreshOnScroll?: undefined;
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
