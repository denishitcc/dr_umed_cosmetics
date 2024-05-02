declare namespace _default {
    let _id: string;
    let type: string;
    let components: ({
        label: string;
        tableView: boolean;
        modalEdit: boolean;
        provider: string;
        key: string;
        type: string;
        providerOptions: {
            params: {
                autocompleteOptions: {};
                key: string;
            };
        };
        input: boolean;
        components: {
            label: string;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
            customConditional: string;
        }[];
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        modalEdit?: undefined;
        provider?: undefined;
        providerOptions?: undefined;
        components?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
