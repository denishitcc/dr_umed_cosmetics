declare namespace _default {
    let _id: string;
    let title: string;
    let name: string;
    let path: string;
    let type: string;
    let display: string;
    let components: ({
        label: string;
        inputMask: string;
        applyMaskOn: string;
        tableView: boolean;
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
        inputMask?: undefined;
        applyMaskOn?: undefined;
    })[];
    let settings: {};
    let properties: {};
    let project: string;
    let controller: string;
    let revisions: string;
    let submissionRevisions: string;
    let created: string;
    let modified: string;
    let machineName: string;
}
export default _default;
