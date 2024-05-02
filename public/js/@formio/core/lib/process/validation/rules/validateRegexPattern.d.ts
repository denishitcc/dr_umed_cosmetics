import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateRegexPattern: RuleFn;
export declare const validateRegexPatternSync: RuleFnSync;
export declare const validateRegexPatternInfo: ProcessorInfo<ValidationContext, FieldError | null>;
