"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.databaseRules = void 0;
const validateUnique_1 = require("./validateUnique");
const validateCaptcha_1 = require("./validateCaptcha");
const validateResourceSelectValue_1 = require("./validateResourceSelectValue");
// These are the validations that require a database connection.
exports.databaseRules = [
    validateUnique_1.validateUniqueInfo,
    validateCaptcha_1.validateCaptchaInfo,
    validateResourceSelectValue_1.validateResourceSelectValueInfo
];
