"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.clientRules = void 0;
const validateDate_1 = require("./validateDate");
const validateDay_1 = require("./validateDay");
const validateEmail_1 = require("./validateEmail");
const validateJson_1 = require("./validateJson");
const validateMask_1 = require("./validateMask");
const validateMaximumDay_1 = require("./validateMaximumDay");
const validateMaximumLength_1 = require("./validateMaximumLength");
const validateMaximumSelectedCount_1 = require("./validateMaximumSelectedCount");
const validateMaximumValue_1 = require("./validateMaximumValue");
const validateMaximumWords_1 = require("./validateMaximumWords");
const validateMaximumYear_1 = require("./validateMaximumYear");
const validateMinimumDay_1 = require("./validateMinimumDay");
const validateMinimumLength_1 = require("./validateMinimumLength");
const validateMinimumSelectedCount_1 = require("./validateMinimumSelectedCount");
const validateMinimumValue_1 = require("./validateMinimumValue");
const validateMinimumWords_1 = require("./validateMinimumWords");
const validateMinimumYear_1 = require("./validateMinimumYear");
const validateMultiple_1 = require("./validateMultiple");
const validateRegexPattern_1 = require("./validateRegexPattern");
const validateRequired_1 = require("./validateRequired");
const validateRequiredDay_1 = require("./validateRequiredDay");
const validateTime_1 = require("./validateTime");
const validateUrl_1 = require("./validateUrl");
const validateValueProperty_1 = require("./validateValueProperty");
const validateNumber_1 = require("./validateNumber");
// These are the validations that are performed in the client.
exports.clientRules = [
    validateDate_1.validateDateInfo,
    validateDay_1.validateDayInfo,
    validateEmail_1.validateEmailInfo,
    validateJson_1.validateJsonInfo,
    validateMask_1.validateMaskInfo,
    validateMaximumDay_1.validateMaximumDayInfo,
    validateMaximumLength_1.validateMaximumLengthInfo,
    validateMaximumSelectedCount_1.validateMaximumSelectedCountInfo,
    validateMaximumValue_1.validateMaximumValueInfo,
    validateMaximumWords_1.validateMaximumWordsInfo,
    validateMaximumYear_1.validateMaximumYearInfo,
    validateMinimumDay_1.validateMinimumDayInfo,
    validateMinimumLength_1.validateMinimumLengthInfo,
    validateMinimumSelectedCount_1.validateMinimumSelectedCountInfo,
    validateMinimumValue_1.validateMinimumValueInfo,
    validateMinimumWords_1.validateMinimumWordsInfo,
    validateMinimumYear_1.validateMinimumYearInfo,
    validateMultiple_1.validateMultipleInfo,
    validateRegexPattern_1.validateRegexPatternInfo,
    validateRequired_1.validateRequiredInfo,
    validateRequiredDay_1.validateRequiredDayInfo,
    validateTime_1.validateTimeInfo,
    validateUrl_1.validateUrlInfo,
    validateValueProperty_1.validateValuePropertyInfo,
    validateNumber_1.validateNumberInfo
];
