"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.generateProcessorContext = void 0;
const get_1 = __importDefault(require("lodash/get"));
const generateProcessorContext = (component, data) => {
    return {
        component,
        path: component.key,
        data,
        row: data,
        scope: {},
        value: (0, get_1.default)(data, component.key),
    };
};
exports.generateProcessorContext = generateProcessorContext;
