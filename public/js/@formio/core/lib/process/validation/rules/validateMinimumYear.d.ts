import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMinimumYear: RuleFn;
export declare const validateMinimumYearSync: RuleFnSync;
export declare const validateMinimumYearInfo: ProcessorInfo<ValidationContext, FieldError | null>;
