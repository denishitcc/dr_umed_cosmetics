import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateRequiredDay: RuleFn;
export declare const validateRequiredDaySync: RuleFnSync;
export declare const validateRequiredDayInfo: ProcessorInfo<ValidationContext, FieldError | null>;
