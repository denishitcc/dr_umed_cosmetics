import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateRequired: RuleFn;
export declare const validateRequiredSync: RuleFnSync;
export declare const validateRequiredInfo: ProcessorInfo<ValidationContext, FieldError | null>;
