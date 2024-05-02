"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.populateProcessInfo = exports.populateProcessSync = void 0;
const set_1 = __importDefault(require("lodash/set"));
const get_1 = __importDefault(require("lodash/get"));
const formUtil_1 = require("../../utils/formUtil");
// This processor ensures that a "linked" row context is provided to every component.
const populateProcessSync = (context) => {
    const { component, path, scope } = context;
    const { data } = scope;
    const compDataPath = (0, formUtil_1.componentPath)(component, (0, formUtil_1.getContextualRowPath)(component, path));
    const compData = (0, get_1.default)(data, compDataPath);
    if (!scope.populated)
        scope.populated = [];
    switch ((0, formUtil_1.getModelType)(component)) {
        case 'array':
            if (!compData || !compData.length) {
                (0, set_1.default)(data, compDataPath, [{}]);
                scope.row = (0, get_1.default)(data, compDataPath)[0];
                scope.populated.push({
                    path,
                    row: (0, get_1.default)(data, compDataPath)[0]
                });
            }
            break;
        case 'dataObject':
        case 'object':
            if (!compData || typeof compData !== 'object') {
                (0, set_1.default)(data, compDataPath, {});
                scope.row = (0, get_1.default)(data, compDataPath);
                scope.populated.push({
                    path,
                    row: (0, get_1.default)(data, compDataPath)
                });
            }
            break;
    }
};
exports.populateProcessSync = populateProcessSync;
exports.populateProcessInfo = {
    name: 'populate',
    shouldProcess: (context) => true,
    processSync: exports.populateProcessSync,
};
