import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateUrlSync: RuleFnSync;
export declare const validateUrl: RuleFn;
export declare const validateUrlInfo: ProcessorInfo<ValidationContext, FieldError | null>;
