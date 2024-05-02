declare namespace _default {
    let _id: string;
    let type: string;
    let owner: string;
    let components: ({
        label: string;
        inputType: string;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        inputMask: string;
        showValidations?: undefined;
        disableOnInvalid?: undefined;
    } | {
        label: string;
        showValidations: boolean;
        disableOnInvalid: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        inputType?: undefined;
        inputMask?: undefined;
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
