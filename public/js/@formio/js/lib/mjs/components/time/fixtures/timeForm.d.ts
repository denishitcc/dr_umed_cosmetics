declare namespace _default {
    let _id: string;
    let type: string;
    let tags: never[];
    let owner: string;
    let components: ({
        label: string;
        inputType: string;
        tableView: boolean;
        validate: {
            required: boolean;
        };
        key: string;
        type: string;
        format: string;
        input: boolean;
        inputMask: string;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        inputType?: undefined;
        validate?: undefined;
        format?: undefined;
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
    let submissionAccess: never[];
    let settings: {};
    let properties: {};
    let name: string;
    let path: string;
    let project: string;
}
export default _default;
