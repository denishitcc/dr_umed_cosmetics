import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateDay: RuleFn;
export declare const validateDaySync: RuleFnSync;
export declare const validateDayInfo: ProcessorInfo<ValidationContext, FieldError | null>;
