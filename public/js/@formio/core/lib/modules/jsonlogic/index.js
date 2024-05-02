"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.interpolate = exports.evaluate = void 0;
const utils_1 = require("../../utils");
const jsonLogic_1 = require("./jsonLogic");
class JSONLogicEvaluator extends utils_1.BaseEvaluator {
    static evaluate(func, args = {}, ret = '', tokenize = false, context = {}) {
        let returnVal = null;
        if (typeof func === 'object') {
            try {
                returnVal = jsonLogic_1.jsonLogic.apply(func, args);
            }
            catch (err) {
                returnVal = null;
                console.warn(`An error occured within JSON Logic`, err);
            }
        }
        else {
            returnVal = utils_1.BaseEvaluator.evaluate(func, args, ret, tokenize, context);
        }
        return returnVal;
    }
}
function evaluate(context, evaluation, ret = 'result', evalContextFn, fnName, options = {}) {
    const { evalContext, instance } = context;
    const evalContextValue = evalContext ? evalContext(context) : context;
    if (evalContextFn) {
        evalContextFn(evalContextValue);
    }
    fnName = fnName || 'evaluate';
    if (instance && instance[fnName]) {
        evaluation = `var ${ret}; ${ret} = ${evaluation}; return ${ret}`;
        return instance[fnName](evaluation, evalContextValue, options);
    }
    return JSONLogicEvaluator[fnName](evaluation, evalContextValue, ret);
}
exports.evaluate = evaluate;
function interpolate(context, evaluation, evalContextFn) {
    return evaluate(context, evaluation, undefined, evalContextFn, 'interpolate', {
        noeval: true
    });
}
exports.interpolate = interpolate;
exports.default = {
    evaluator: JSONLogicEvaluator,
    jsonLogic: jsonLogic_1.jsonLogic
};
