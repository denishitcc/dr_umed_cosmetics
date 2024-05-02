declare namespace _default {
    let type: string;
    let display: string;
    let components: ({
        label: string;
        tableView: boolean;
        datePicker: {
            disableWeekends: boolean;
            disableWeekdays: boolean;
            disableFunction?: undefined;
        };
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
            disableFunction?: undefined;
        };
        validate?: undefined;
        customConditional?: undefined;
        disableOnInvalid?: undefined;
    } | {
        label: string;
        tableView: boolean;
        enableMinDateInput: boolean;
        datePicker: {
            disableWeekends: boolean;
            disableWeekdays: boolean;
            disableFunction?: undefined;
        };
        enableMaxDateInput: boolean;
        validate: {
            custom: string;
        };
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
            disableFunction?: undefined;
        };
        customConditional?: undefined;
        disableOnInvalid?: undefined;
    } | {
        label: string;
        tableView: boolean;
        datePicker: {
            disableFunction: string;
            disableWeekends: boolean;
            disableWeekdays: boolean;
        };
        enableMinDateInput: boolean;
        enableMaxDateInput: boolean;
        key: string;
        customConditional: string;
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
            disableFunction: string;
            maxDate: null;
        };
        validate?: undefined;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        datePicker?: undefined;
        enableMinDateInput?: undefined;
        enableMaxDateInput?: undefined;
        widget?: undefined;
        validate?: undefined;
        customConditional?: undefined;
    })[];
}
export default _default;
