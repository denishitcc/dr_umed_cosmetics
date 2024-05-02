import { FieldError } from '../../../error/FieldError';
import { RuleFn, ValidationContext } from '../../../types/index';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateCaptcha: RuleFn;
export declare const validateCaptchaInfo: ProcessorInfo<ValidationContext, FieldError | null>;
