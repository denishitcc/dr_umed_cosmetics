import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateJson: RuleFn;
export declare const validateJsonSync: RuleFnSync;
export declare const validateJsonInfo: ProcessorInfo<ValidationContext, FieldError | null>;
