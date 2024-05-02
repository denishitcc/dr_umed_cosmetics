import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMinimumValue: RuleFn;
export declare const validateMinimumValueSync: RuleFnSync;
export declare const validateMinimumValueInfo: ProcessorInfo<ValidationContext, FieldError | null>;
