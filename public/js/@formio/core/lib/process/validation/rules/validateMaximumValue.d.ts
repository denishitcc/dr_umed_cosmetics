import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMaximumValue: RuleFn;
export declare const validateMaximumValueSync: RuleFnSync;
export declare const validateMaximumValueInfo: ProcessorInfo<ValidationContext, FieldError | null>;
