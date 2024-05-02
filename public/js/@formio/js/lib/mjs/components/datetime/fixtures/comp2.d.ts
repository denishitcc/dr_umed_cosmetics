declare namespace _default {
    export let type: string;
    export namespace validate {
        let custom: string;
        let required: boolean;
    }
    export let shortcutButtons: {
        label: string;
        onClick: string;
    }[];
    export let persistent: boolean;
    let _protected: boolean;
    export { _protected as protected };
    export namespace timePicker {
        let arrowkeys: boolean;
        let mousewheel: boolean;
        let readonlyInput: boolean;
        let showMeridian: boolean;
        let minuteStep: number;
        let hourStep: number;
    }
    export namespace datePicker {
        let datepickerMode: string;
        let yearRange: string;
        let maxMode: string;
        let minMode: string;
        let initDate: string;
        let startingDay: number;
        let showWeeks: boolean;
    }
    let datepickerMode_1: string;
    export { datepickerMode_1 as datepickerMode };
    export let defaultDate: string;
    export let enableTime: boolean;
    export let enableDate: boolean;
    export let format: string;
    export let key: string;
    export let label: string;
    export let tableView: boolean;
    export let input: boolean;
}
export default _default;
