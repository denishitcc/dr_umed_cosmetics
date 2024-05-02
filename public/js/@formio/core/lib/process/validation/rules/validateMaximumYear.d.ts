import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMaximumYear: RuleFn;
export declare const validateMaximumYearSync: RuleFnSync;
export declare const validateMaximumYearInfo: ProcessorInfo<ValidationContext, FieldError | null>;
