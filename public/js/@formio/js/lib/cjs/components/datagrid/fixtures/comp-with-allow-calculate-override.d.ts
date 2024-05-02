declare namespace _default {
    let type: string;
    let display: string;
    let components: ({
        label: string;
        widget: string;
        tableView: boolean;
        data: {
            values: {
                label: string;
                value: string;
            }[];
        };
        key: string;
        type: string;
        input: boolean;
        reorder?: undefined;
        addAnotherPosition?: undefined;
        layoutFixed?: undefined;
        enableRowGroups?: undefined;
        initEmpty?: undefined;
        defaultValue?: undefined;
        calculateValue?: undefined;
        allowCalculateOverride?: undefined;
        components?: undefined;
    } | {
        label: string;
        reorder: boolean;
        addAnotherPosition: string;
        layoutFixed: boolean;
        enableRowGroups: boolean;
        initEmpty: boolean;
        tableView: boolean;
        defaultValue: {
            firstName: string;
            lastName: string;
        }[];
        calculateValue: string;
        allowCalculateOverride: boolean;
        key: string;
        type: string;
        input: boolean;
        components: {
            label: string;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
        }[];
        widget?: undefined;
        data?: undefined;
    })[];
}
export default _default;
