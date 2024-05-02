import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const validateMaximumWords: RuleFn;
export declare const validateMaximumWordsSync: RuleFnSync;
export declare const validateMaximumWordsInfo: ProcessorInfo<ValidationContext, FieldError | null>;
