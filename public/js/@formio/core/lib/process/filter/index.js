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
exports.filterProcessInfo = exports.filterPostProcess = exports.filterProcess = exports.filterProcessSync = void 0;
const set_1 = __importDefault(require("lodash/set"));
const utils_1 = require("../../utils");
const lodash_1 = require("lodash");
const formUtil_1 = require("../../utils/formUtil");
const filterProcessSync = (context) => {
    const { scope, component } = context;
    let { value } = context;
    const absolutePath = (0, formUtil_1.getComponentAbsolutePath)(component);
    if (!scope.filter)
        scope.filter = {};
    if (value !== undefined) {
        const modelType = utils_1.Utils.getModelType(component);
        switch (modelType) {
            case 'dataObject':
                scope.filter[absolutePath] = {
                    compModelType: modelType,
                    include: true,
                    value: { data: {} }
                };
                break;
            case 'array':
                scope.filter[absolutePath] = {
                    compModelType: modelType,
                    include: true,
                };
                break;
            case 'object':
                if (component.type !== 'container') {
                    scope.filter[absolutePath] = {
                        compModelType: modelType,
                        include: true,
                    };
                }
                break;
            default:
                scope.filter[absolutePath] = {
                    compModelType: modelType,
                    include: true,
                };
                break;
        }
    }
};
exports.filterProcessSync = filterProcessSync;
const filterProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.filterProcessSync)(context);
});
exports.filterProcess = filterProcess;
const filterPostProcess = (context) => {
    const { scope, submission } = context;
    const filtered = {};
    for (const path in scope.filter) {
        if (scope.filter[path].include) {
            let value = (0, lodash_1.get)(submission === null || submission === void 0 ? void 0 : submission.data, path);
            if ((0, lodash_1.isObject)(value) && (0, lodash_1.isObject)(scope.filter[path].value)) {
                if (scope.filter[path].compModelType === 'dataObject') {
                    value = Object.assign(Object.assign(Object.assign({}, value), scope.filter[path].value), { data: value === null || value === void 0 ? void 0 : value.data });
                }
                else {
                    value = Object.assign(Object.assign({}, value), scope.filter[path].value);
                }
            }
            (0, set_1.default)(filtered, path, value);
        }
    }
    context.data = filtered;
};
exports.filterPostProcess = filterPostProcess;
exports.filterProcessInfo = {
    name: 'filter',
    process: exports.filterProcess,
    processSync: exports.filterProcessSync,
    postProcess: exports.filterPostProcess,
    shouldProcess: (context) => true,
};
