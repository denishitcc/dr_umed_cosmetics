"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.asynchronousRules = void 0;
const validateUrlSelectValue_1 = require("./validateUrlSelectValue");
// These are the validations that are asynchronouse (e.g. require fetch
exports.asynchronousRules = [
    validateUrlSelectValue_1.validateUrlSelectValueInfo,
];
