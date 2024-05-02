import { RuleFn, RuleFnSync, ProcessorInfo, ValidationContext } from 'types';
import { FieldError } from 'error';
export declare const validateCustom: RuleFn;
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateCustomSync: RuleFnSync;
export declare const validateCustomInfo: ProcessorInfo<ValidationContext, FieldError | null>;
