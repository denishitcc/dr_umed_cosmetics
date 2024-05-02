declare namespace _default {
    let type: string;
    let components: ({
        label: string;
        tableView: boolean;
        validate: {
            required: boolean;
            minLength: number;
        };
        key: string;
        type: string;
        input: boolean;
        components?: undefined;
        action?: undefined;
        showValidations?: undefined;
        theme?: undefined;
        state?: undefined;
        saveOnEnter?: undefined;
    } | {
        label: string;
        tableView: boolean;
        validate: {
            required: boolean;
            minLength?: undefined;
        };
        key: string;
        type: string;
        input: boolean;
        components: {
            label: string;
            tableView: boolean;
            validate: {
                required: boolean;
                minLength: number;
            };
            key: string;
            type: string;
            input: boolean;
        }[];
        action?: undefined;
        showValidations?: undefined;
        theme?: undefined;
        state?: undefined;
        saveOnEnter?: undefined;
    } | {
        label: string;
        action: string;
        showValidations: boolean;
        theme: string;
        tableView: boolean;
        key: string;
        type: string;
        state: string;
        input: boolean;
        validate?: undefined;
        components?: undefined;
        saveOnEnter?: undefined;
    } | {
        label: string;
        showValidations: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        saveOnEnter: boolean;
        validate?: undefined;
        components?: undefined;
        action?: undefined;
        theme?: undefined;
        state?: undefined;
    })[];
    let display: string;
    let name: string;
    let path: string;
    let project: string;
}
export default _default;
