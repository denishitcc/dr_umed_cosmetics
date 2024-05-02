import { FieldError } from '../../../error/FieldError';
import { RuleFn, ValidationContext } from '../../../types/index';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateUnique: RuleFn;
export declare const validateUniqueInfo: ProcessorInfo<ValidationContext, FieldError | null>;
