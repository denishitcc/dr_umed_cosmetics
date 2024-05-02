import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMinimumSelectedCount: RuleFn;
export declare const validateMinimumSelectedCountSync: RuleFnSync;
export declare const validateMinimumSelectedCountInfo: ProcessorInfo<ValidationContext, FieldError | null>;
