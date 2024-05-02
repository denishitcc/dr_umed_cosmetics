declare const _default: {
    evaluator: {
        new (): {};
        evaluate(func: any, args?: any, ret?: any, tokenize?: boolean, context?: any): any;
        templateSettings: {
            interpolate: RegExp;
            evaluate: RegExp;
            escape: RegExp;
        };
        noeval: boolean;
        evaluator(func: any, ...params: any): any;
        interpolateString(rawTemplate: string, data: any, options?: any): any;
        interpolate(rawTemplate: any, data: any, options?: any): any;
        execute(func: any, args: any, context?: any, options?: any): any;
    };
    jsonLogic: typeof import("json-logic-js");
}[];
export default _default;
