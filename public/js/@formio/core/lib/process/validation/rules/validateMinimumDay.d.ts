import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMinimumDay: RuleFn;
export declare const validateMinimumDaySync: RuleFnSync;
export declare const validateMinimumDayInfo: ProcessorInfo<ValidationContext, FieldError | null>;
