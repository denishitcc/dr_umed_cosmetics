declare namespace _default {
    let _id: string;
    let type: string;
    let owner: string;
    let components: ({
        label: string;
        tableView: boolean;
        modal: boolean;
        validate: {
            required: boolean;
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
        showValidations?: undefined;
    } | {
        label: string;
        showValidations: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        modal?: undefined;
        validate?: undefined;
        components?: undefined;
    })[];
    let controller: string;
    let revisions: string;
    let _vid: number;
    let title: string;
    let display: string;
    let access: {
        roles: string[];
        type: string;
    }[];
    let name: string;
    let path: string;
}
export default _default;
