import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const validateRequiredSurvey: RuleFn;
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateRequiredSurveySync: RuleFnSync;
export declare const validateRequiredSurveyInfo: ProcessorInfo<ValidationContext, FieldError | null>;
