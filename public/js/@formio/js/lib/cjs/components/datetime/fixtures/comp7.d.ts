declare namespace _default {
    let _id: string;
    let title: string;
    let name: string;
    let path: string;
    let type: string;
    let display: string;
    let components: ({
        label: string;
        format: string;
        tableView: boolean;
        datePicker: {
            disableWeekends: boolean;
            disableWeekdays: boolean;
        };
        enableTime: boolean;
        enableMinDateInput: boolean;
        enableMaxDateInput: boolean;
        key: string;
        type: string;
        input: boolean;
        widget: {
            type: string;
            displayInTimezone: string;
            locale: string;
            useLocaleSettings: boolean;
            allowInput: boolean;
            mode: string;
            enableTime: boolean;
            noCalendar: boolean;
            format: string;
            hourIncrement: number;
            minuteIncrement: number;
            time_24hr: boolean;
            minDate: null;
            disableWeekends: boolean;
            disableWeekdays: boolean;
            maxDate: null;
        };
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        format?: undefined;
        datePicker?: undefined;
        enableTime?: undefined;
        enableMinDateInput?: undefined;
        enableMaxDateInput?: undefined;
        widget?: undefined;
    })[];
    let settings: {};
    let properties: {};
    let project: string;
}
export default _default;
