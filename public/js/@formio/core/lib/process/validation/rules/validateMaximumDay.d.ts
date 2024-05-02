import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMaximumDay: RuleFn;
export declare const validateMaximumDaySync: RuleFnSync;
export declare const validateMaximumDayInfo: ProcessorInfo<ValidationContext, FieldError | null>;
