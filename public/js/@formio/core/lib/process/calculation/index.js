"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.calculateProcessInfo = exports.calculateProcess = exports.calculateProcessSync = exports.shouldCalculate = void 0;
const jsonlogic_1 = __importDefault(require("../../modules/jsonlogic"));
const set_1 = __importDefault(require("lodash/set"));
const Evaluator = jsonlogic_1.default.evaluator;
const shouldCalculate = (context) => {
    const { component, config } = context;
    if (!component.calculateValue ||
        ((config === null || config === void 0 ? void 0 : config.server) && !component.calculateServer)) {
        return false;
    }
    return true;
};
exports.shouldCalculate = shouldCalculate;
const calculateProcessSync = (context) => {
    const { component, data, evalContext, scope, path, value } = context;
    if (!(0, exports.shouldCalculate)(context)) {
        return;
    }
    const evalContextValue = evalContext ? evalContext(context) : context;
    evalContextValue.value = value || null;
    if (!scope.calculated)
        scope.calculated = [];
    let newValue = Evaluator.evaluate(component.calculateValue, evalContextValue, 'value');
    // Only set a new value if it is not "null" which would be the case if no calculation occurred.
    if (newValue !== null) {
        scope.calculated.push({
            path,
            value: newValue
        });
        (0, set_1.default)(data, path, newValue);
    }
    return;
};
exports.calculateProcessSync = calculateProcessSync;
const calculateProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.calculateProcessSync)(context);
});
exports.calculateProcess = calculateProcess;
exports.calculateProcessInfo = {
    name: 'calculate',
    process: exports.calculateProcess,
    processSync: exports.calculateProcessSync,
    shouldProcess: exports.shouldCalculate,
};
