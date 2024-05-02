import { BaseEvaluator } from 'utils';
import { jsonLogic } from './jsonLogic';
declare class JSONLogicEvaluator extends BaseEvaluator {
    static evaluate(func: any, args?: any, ret?: any, tokenize?: boolean, context?: any): any;
}
export type EvaluatorContext = {
    evalContext?: (context: any) => any;
    instance?: any;
    [key: string]: any;
};
export type EvaluatorFn = (context: EvaluatorContext) => any;
export declare function evaluate(context: EvaluatorContext, evaluation: string, ret?: string, evalContextFn?: EvaluatorFn, fnName?: string, options?: any): any;
export declare function interpolate(context: EvaluatorContext, evaluation: string, evalContextFn?: EvaluatorFn): string;
declare const _default: {
    evaluator: typeof JSONLogicEvaluator;
    jsonLogic: typeof jsonLogic;
};
export default _default;
