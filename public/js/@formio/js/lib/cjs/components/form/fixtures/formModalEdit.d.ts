declare namespace _default {
    let _id: string;
    let type: string;
    let owner: string;
    let components: ({
        label: string;
        tableView: boolean;
        modalEdit: boolean;
        components: {
            label: string;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
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
        modalEdit?: undefined;
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
