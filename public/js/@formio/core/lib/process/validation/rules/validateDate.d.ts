import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateDate: RuleFn;
export declare const validateDateSync: RuleFnSync;
export declare const validateDateInfo: ProcessorInfo<ValidationContext, FieldError | null>;
