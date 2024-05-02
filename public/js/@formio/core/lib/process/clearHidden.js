"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.clearHiddenProcessInfo = exports.clearHiddenProcess = void 0;
const unset_1 = __importDefault(require("lodash/unset"));
/**
 * This processor function checks components for the `hidden` property and unsets corresponding data
 */
const clearHiddenProcess = (context) => {
    var _a;
    const { component, data, path, value, scope } = context;
    if (!scope.clearHidden) {
        scope.clearHidden = {};
    }
    const conditionallyHidden = (_a = scope.conditionals) === null || _a === void 0 ? void 0 : _a.find((cond) => {
        return cond.path === path;
    });
    if ((conditionallyHidden === null || conditionallyHidden === void 0 ? void 0 : conditionallyHidden.conditionallyHidden) &&
        (value !== undefined) &&
        (!component.hasOwnProperty('clearOnHide') || component.clearOnHide)) {
        (0, unset_1.default)(data, path);
        scope.clearHidden[path] = true;
    }
};
exports.clearHiddenProcess = clearHiddenProcess;
exports.clearHiddenProcessInfo = {
    name: 'clearHidden',
    shouldProcess: () => true,
    processSync: exports.clearHiddenProcess,
};
