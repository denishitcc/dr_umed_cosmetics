import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMaximumLength: RuleFn;
export declare const validateMaximumLengthSync: RuleFnSync;
export declare const validateMaximumLengthInfo: ProcessorInfo<ValidationContext, FieldError | null>;
