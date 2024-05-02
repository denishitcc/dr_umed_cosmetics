declare namespace _default {
    let _id: string;
    let type: string;
    let components: ({
        label: string;
        format: string;
        tableView: boolean;
        enableMinDateInput: boolean;
        datePicker: {
            minDate: string;
            disableFunction: string;
            disableWeekends: boolean;
            disableWeekdays: boolean;
        };
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
            minDate: string;
            disableWeekends: boolean;
            disableWeekdays: boolean;
            disableFunction: string;
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
        enableMinDateInput?: undefined;
        datePicker?: undefined;
        enableMaxDateInput?: undefined;
        widget?: undefined;
    })[];
    let title: string;
    let display: string;
    let name: string;
    let path: string;
}
export default _default;
