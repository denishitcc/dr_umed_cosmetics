declare namespace _default {
    let _id: string;
    let type: string;
    let components: ({
        label: string;
        tableView: boolean;
        modalEdit: boolean;
        storage: string;
        webcam: boolean;
        fileTypes: {
            label: string;
            value: string;
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
        storage?: undefined;
        webcam?: undefined;
        fileTypes?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
