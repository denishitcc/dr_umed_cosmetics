import { FieldError } from 'error/FieldError';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMinimumWords: RuleFn;
export declare const validateMinimumWordsSync: RuleFnSync;
export declare const validateMinimumWordsInfo: ProcessorInfo<ValidationContext, FieldError | null>;
