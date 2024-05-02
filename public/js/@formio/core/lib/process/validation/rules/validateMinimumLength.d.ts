import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMinimumLength: RuleFn;
export declare const validateMinimumLengthSync: RuleFnSync;
export declare const validateMinimumLengthInfo: ProcessorInfo<ValidationContext, FieldError | null>;
