"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.Evaluator = exports.BaseEvaluator = void 0;
const lodash_1 = require("lodash");
// BaseEvaluator is for extending.
class BaseEvaluator {
    static evaluator(func, ...params) {
        if (Evaluator.noeval) {
            console.warn('No evaluations allowed for this renderer.');
            return lodash_1.noop;
        }
        if (typeof func === 'function') {
            return func;
        }
        if (typeof params[0] === 'object') {
            params = (0, lodash_1.keys)(params[0]);
        }
        return new Function(...params, func);
    }
    ;
    static interpolateString(rawTemplate, data, options = {}) {
        if (!rawTemplate) {
            return '';
        }
        if (typeof rawTemplate !== 'string') {
            return rawTemplate.toString();
        }
        return rawTemplate.replace(/({{\s*(.*?)\s*}})/g, (match, $1, $2) => {
            // If this is a function call and we allow evals.
            if ($2.indexOf('(') !== -1 && !(Evaluator.noeval || options.noeval)) {
                return $2.replace(/([^\(]+)\(([^\)]+)\s*\);?/, (evalMatch, funcName, args) => {
                    funcName = (0, lodash_1.trim)(funcName);
                    const func = (0, lodash_1.get)(data, funcName);
                    if (func) {
                        if (args) {
                            args = args.split(',').map((arg) => {
                                arg = (0, lodash_1.trim)(arg);
                                if ((arg.indexOf('"') === 0) || (arg.indexOf("'") === 0)) {
                                    return arg.substring(1, arg.length - 1);
                                }
                                return (0, lodash_1.get)(data, arg);
                            });
                        }
                        return Evaluator.evaluate(func, args, '', false, data, options);
                    }
                    return '';
                });
            }
            else {
                let dataPath = $2;
                if ($2.indexOf('?') !== -1) {
                    dataPath = $2.replace(/\?\./g, '.');
                }
                // Allow for conditional values.
                const parts = dataPath.split('||').map((item) => item.trim());
                let value = '';
                let path = '';
                for (let i = 0; i < parts.length; i++) {
                    path = parts[i];
                    value = (0, lodash_1.get)(data, path);
                    if (value) {
                        break;
                    }
                }
                if (options.data) {
                    (0, lodash_1.set)(options.data, path, value);
                }
                return value;
            }
        });
    }
    static interpolate(rawTemplate, data, options = {}) {
        if (typeof rawTemplate === 'function' && !(Evaluator.noeval || options.noeval)) {
            try {
                return rawTemplate(data);
            }
            catch (err) {
                console.warn('Error interpolating template', err, data);
                return err.message;
            }
        }
        return Evaluator.interpolateString(String(rawTemplate), data, options);
    }
    ;
    /**
     * Evaluate a method.
     *
     * @param func
     * @param args
     * @return {*}
     */
    static evaluate(func, args = {}, ret = '', interpolate = false, context = {}, options = {}) {
        let returnVal = null;
        options = (0, lodash_1.isObject)(options) ? options : { noeval: options };
        const component = args.component ? args.component : { key: 'unknown' };
        if (!args.form && args.instance) {
            args.form = (0, lodash_1.get)(args.instance, 'root._form', {});
        }
        const componentKey = component.key;
        if (typeof func === 'string') {
            if (ret) {
                func = `var ${ret};${func};return ${ret}`;
            }
            if (interpolate) {
                func = BaseEvaluator.interpolate(func, args, options);
            }
            try {
                if (Evaluator.noeval || options.noeval) {
                    func = lodash_1.noop;
                }
                else {
                    func = Evaluator.evaluator(func, args, context);
                }
                args = (0, lodash_1.values)(args);
            }
            catch (err) {
                console.warn(`An error occured within the custom function for ${componentKey}`, err);
                returnVal = null;
                func = false;
            }
        }
        if (typeof func === 'function') {
            try {
                returnVal = Evaluator.execute(func, args, context, options);
            }
            catch (err) {
                returnVal = null;
                console.warn(`An error occured within custom function for ${componentKey}`, err);
            }
        }
        else if (func) {
            console.warn(`Unknown function type for ${componentKey}`);
        }
        return returnVal;
    }
    /**
     * Execute a function.
     *
     * @param func
     * @param args
     * @returns
     */
    static execute(func, args, context = {}, options = {}) {
        options = (0, lodash_1.isObject)(options) ? options : { noeval: options };
        if (Evaluator.noeval || options.noeval) {
            console.warn('No evaluations allowed for this renderer.');
            return;
        }
        return Array.isArray(args) ? func.apply(context, args) : func.call(context, args);
    }
    ;
}
exports.BaseEvaluator = BaseEvaluator;
BaseEvaluator.templateSettings = {
    interpolate: /{{([\s\S]+?)}}/g,
    evaluate: /\{%([\s\S]+?)%\}/g,
    escape: /\{\{\{([\s\S]+?)\}\}\}/g
};
BaseEvaluator.noeval = false;
// The extendable evaluator
class Evaluator extends BaseEvaluator {
    /**
     * Allow external modules the ability to extend the Evaluator.
     * @param evaluator
     */
    static registerEvaluator(evaluator) {
        Object.keys(evaluator).forEach((key) => {
            Evaluator[key] = evaluator[key];
        });
    }
}
exports.Evaluator = Evaluator;
