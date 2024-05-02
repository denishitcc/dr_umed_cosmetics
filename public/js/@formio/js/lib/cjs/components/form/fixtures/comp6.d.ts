declare namespace _default {
    let components: ({
        label: string;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        display?: undefined;
        components?: undefined;
        logic?: undefined;
        disableOnInvalid?: undefined;
    } | {
        label: string;
        tableView: boolean;
        display: string;
        components: ({
            label: string;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
            autoExpand?: undefined;
        } | {
            label: string;
            autoExpand: boolean;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
        })[];
        logic: {
            name: string;
            trigger: {
                type: string;
                simple: {
                    show: boolean;
                    when: string;
                    eq: string;
                };
                conditionConditionGrid: never[];
            };
            actions: {
                name: string;
                type: string;
                property: {
                    label: string;
                    value: string;
                    type: string;
                };
                state: boolean;
                variableVariableGrid: never[];
            }[];
        }[];
        key: string;
        type: string;
        input: boolean;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        display?: undefined;
        components?: undefined;
        logic?: undefined;
    })[];
    let title: string;
    let display: string;
    let path: string;
    let name: string;
}
export default _default;
