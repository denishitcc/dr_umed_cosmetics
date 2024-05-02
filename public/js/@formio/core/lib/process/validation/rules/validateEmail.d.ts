import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateEmail: RuleFn;
export declare const validateEmailSync: RuleFnSync;
export declare const validateEmailInfo: ProcessorInfo<ValidationContext, FieldError | null>;
