import { FieldError } from 'error';
import { SelectComponent, RuleFn, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const generateUrl: (baseUrl: URL, component: SelectComponent, value: any) => URL;
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateResourceSelectValue: RuleFn;
export declare const validateResourceSelectValueInfo: ProcessorInfo<ValidationContext, FieldError | null>;
