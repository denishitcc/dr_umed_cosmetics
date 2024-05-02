import { ValidationContext } from 'types';
type FieldErrorContext = ValidationContext & {
    field?: string;
    level?: string;
    hasLabel?: boolean;
    setting?: string | boolean | number;
    min?: string;
    max?: string;
    length?: string;
    pattern?: string;
    minCount?: string;
    maxCount?: string;
    minDate?: string;
    maxDate?: string;
    minYear?: string;
    maxYear?: string;
    regex?: string;
};
export declare class FieldError {
    context: FieldErrorContext;
    errorKeyOrMessage: string;
    ruleName: string;
    level?: string;
    constructor(errorKeyOrMessage: string, context: FieldErrorContext, ruleName?: string);
}
export type InterpolateErrorFn = (text: string, context: FieldErrorContext) => string;
export {};
