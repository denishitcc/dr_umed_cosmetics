declare namespace _default {
    let type: string;
    let components: ({
        label: string;
        tableView: boolean;
        provider: string;
        key: string;
        type: string;
        providerOptions: {
            params: {
                autocompleteOptions: {};
            };
            url: string;
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
        defaultValue: {
            place_id: number;
            licence: string;
            osm_type: string;
            osm_id: number;
            boundingbox: string[];
            lat: string;
            lon: string;
            display_name: string;
            class: string;
            type: string;
            importance: number;
            icon: string;
            address: {
                county: string;
                state: string;
                country: string;
                country_code: string;
            };
        };
        showValidations?: undefined;
    } | {
        label: string;
        showValidations: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        provider?: undefined;
        providerOptions?: undefined;
        components?: undefined;
        defaultValue?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
