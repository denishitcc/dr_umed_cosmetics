"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.evaluationRules = void 0;
const validateCustom_1 = require("./validateCustom");
const validateAvailableItems_1 = require("./validateAvailableItems");
exports.evaluationRules = [
    validateCustom_1.validateCustomInfo,
    validateAvailableItems_1.validateAvailableItemsInfo
];
