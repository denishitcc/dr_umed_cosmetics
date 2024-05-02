import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMaximumSelectedCount: RuleFn;
export declare const validateMaximumSelectedCountSync: RuleFnSync;
export declare const validateMaximumSelectedCountInfo: ProcessorInfo<ValidationContext, FieldError | null>;
