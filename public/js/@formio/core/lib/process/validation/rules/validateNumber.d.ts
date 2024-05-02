import { FieldError } from '../../../error/FieldError';
import { RuleFn, RuleFnSync, ValidationContext } from '../../../types/index';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateNumber: RuleFn;
export declare const validateNumberSync: RuleFnSync;
export declare const validateNumberInfo: ProcessorInfo<ValidationContext, FieldError | null>;
